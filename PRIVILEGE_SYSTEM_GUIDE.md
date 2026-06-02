# Privilege Control System - Implementation Guide

## Overview

This system implements a robust privilege control mechanism based on your legacy system's menu-based permissions, but with **proper security** that actually restricts unauthorized access (not just hides menus).

## Key Differences from Legacy System

### Legacy System Issues
- ❌ Only hid menu items in UI
- ❌ Did NOT restrict actual page access
- ❌ Users could access pages by typing URLs directly
- ❌ No middleware protection

### New Laravel System
- ✅ Blocks unauthorized access at route level
- ✅ Middleware protection on all routes
- ✅ Server-side validation
- ✅ Still hides UI elements for better UX
- ✅ Works with API endpoints

## Database Structure

Your existing tables (no changes needed):
- `tbl_user` - User accounts
- `tbl_user_type` - User types/roles
- `tbl_menu_list` - Available menus
- `tbl_user_privilege` - User permissions per menu

Privilege columns in `tbl_user_privilege`:
- `add` - Can create new records (1/0)
- `edit` - Can edit existing records (1/0)
- `statuschange` - Can change status (1/0)
- `remove` - Can delete records (1/0)
- `access_status` - Can access this menu (1/0)
- `status` - Privilege is active (1/0)

## Setup Instructions

### 1. Run Composer Autoload

After adding the helper file, run:
```bash
composer dump-autoload
```

### 2. Update Your Existing Controllers

Add privilege checks to your existing controllers. Example for CustomerController:

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    const MENU_ID = 7; // Customer menu ID

    public function index()
    {
        // Method 1: Auto-abort if no access (simplest)
        authorizePrivilege(self::MENU_ID);

        $customers = Customer::all();
        $privileges = getMenuPrivileges(self::MENU_ID);
        
        return view('customer.index', compact('customers', 'privileges'));
    }

    public function store(Request $request)
    {
        // Check 'add' privilege
        authorizePrivilege(self::MENU_ID, 'add');

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            // ... other fields
        ]);

        $customer = Customer::create($validated);

        return redirect()->route('customer.index')
            ->with('success', 'Customer added successfully.');
    }

    public function update(Request $request, $id)
    {
        // Check 'edit' privilege
        authorizePrivilege(self::MENU_ID, 'edit');

        $customer = Customer::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            // ... other fields
        ]);

        $customer->update($validated);

        return redirect()->route('customer.index')
            ->with('success', 'Customer updated successfully.');
    }

    public function updateStatus($id)
    {
        // Check 'statuschange' privilege
        authorizePrivilege(self::MENU_ID, 'statuschange');

        $customer = Customer::findOrFail($id);
        $customer->status = $customer->status == 1 ? 0 : 1;
        $customer->save();

        return redirect()->back()
            ->with('success', 'Status updated successfully.');
    }

    public function destroy($id)
    {
        // Check 'remove' privilege
        authorizePrivilege(self::MENU_ID, 'remove');

        $customer = Customer::findOrFail($id);
        $customer->delete();

        return redirect()->route('customer.index')
            ->with('success', 'Customer deleted successfully.');
    }
}
```

### 3. Protect Your Routes

Update your route files (e.g., `routes/customer.php`):

```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;

Route::middleware(['auth'])->prefix('customer')->name('customer.')->group(function () {
    // List - requires menu access only
    Route::get('/', [CustomerController::class, 'index'])
        ->middleware('privilege:7')
        ->name('index');

    // Create - requires 'add' privilege
    Route::get('/create', [CustomerController::class, 'create'])
        ->middleware('privilege:7,add')
        ->name('create');

    Route::post('/', [CustomerController::class, 'store'])
        ->middleware('privilege:7,add')
        ->name('store');

    // Edit - requires 'edit' privilege
    Route::get('/{id}/edit', [CustomerController::class, 'edit'])
        ->middleware('privilege:7,edit')
        ->name('edit');

    Route::put('/{id}', [CustomerController::class, 'update'])
        ->middleware('privilege:7,edit')
        ->name('update');

    // Status - requires 'statuschange' privilege
    Route::patch('/{id}/status', [CustomerController::class, 'updateStatus'])
        ->middleware('privilege:7,statuschange')
        ->name('status');

    // Delete - requires 'remove' privilege
    Route::delete('/{id}', [CustomerController::class, 'destroy'])
        ->middleware('privilege:7,remove')
        ->name('destroy');
});
```

### 4. Update Your Blade Views

Add privilege checks to show/hide UI elements:

```blade
{{-- resources/views/customer/index.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4>Customers</h4>
            
            {{-- Show Add button only if user has 'add' privilege --}}
            @if(checkPrivilege(7, 'add'))
                <a href="{{ route('customer.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add Customer
                </a>
            @endif
        </div>

        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        
                        {{-- Show Actions column only if user has any modify privilege --}}
                        @if(hasAnyPrivilege(7, ['edit', 'statuschange', 'remove']))
                            <th>Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($customers as $customer)
                        <tr>
                            <td>{{ $customer->id }}</td>
                            <td>{{ $customer->name }}</td>
                            <td>{{ $customer->email }}</td>
                            <td>
                                @if($customer->status == 1)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                            
                            @if(hasAnyPrivilege(7, ['edit', 'statuschange', 'remove']))
                                <td>
                                    @if(checkPrivilege(7, 'edit'))
                                        <a href="{{ route('customer.edit', $customer->id) }}" 
                                           class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endif

                                    @if(checkPrivilege(7, 'statuschange'))
                                        <form action="{{ route('customer.status', $customer->id) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-info">
                                                <i class="fas fa-toggle-on"></i>
                                            </button>
                                        </form>
                                    @endif

                                    @if(checkPrivilege(7, 'remove'))
                                        <form action="{{ route('customer.destroy', $customer->id) }}" 
                                              method="POST" class="d-inline"
                                              onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
```

## Available Helper Functions

### 1. `checkPrivilege($menuId, $action)`
Check if user has specific privilege.
```php
if (checkPrivilege(7, 'add')) {
    // User can add customers
}
```

### 2. `canAccessMenu($menuId)`
Check if user can access a menu.
```php
if (canAccessMenu(7)) {
    // User can access customer menu
}
```

### 3. `getMenuPrivileges($menuId)`
Get all privileges for a menu as array.
```php
$privileges = getMenuPrivileges(7);
// Returns: ['add' => true, 'edit' => true, 'statuschange' => false, 'remove' => false, 'canAccess' => true]
```

### 4. `authorizePrivilege($menuId, $action = null)`
Authorize or abort with 403 error.
```php
authorizePrivilege(7); // Check access
authorizePrivilege(7, 'add'); // Check specific action
```

### 5. `hasAnyPrivilege($menuId, array $actions)`
Check if user has ANY of the specified privileges.
```php
if (hasAnyPrivilege(7, ['edit', 'remove'])) {
    // User can edit OR remove
}
```

### 6. `hasAllPrivileges($menuId, array $actions)`
Check if user has ALL specified privileges.
```php
if (hasAllPrivileges(7, ['edit', 'statuschange'])) {
    // User can edit AND change status
}
```

### 7. `getUserAccessibleMenus()`
Get all menus the user has access to.
```php
$menus = getUserAccessibleMenus();
```

## Menu ID Reference

Based on your legacy system:

| Menu ID | Page | Description |
|---------|------|-------------|
| 1 | useraccount.php | User Accounts |
| 2 | usertype.php | User Types |
| 3 | userprivilege.php | User Privileges |
| 4 | locations.php | Locations |
| 7 | customer.php | Customers |
| 8 | supplier.php | Suppliers |
| 9 | product.php | Products |
| 10 | productcategory.php | Product Categories |
| 11 | groupcategory.php | Group Categories |
| 12 | subproductcategory.php | Sub Categories |
| 13 | sizecategories.php | Size Categories |
| 14 | sizematrix.php | Size Matrix |
| 27 | employee.php | Employees |
| 28 | area.php | Areas |
| 47 | salesmanager.php | Sales Managers |
| ... | ... | ... |

## Action Types

- `add` - Create new records
- `edit` - Modify existing records
- `statuschange` - Toggle status (active/inactive)
- `remove` - Delete records

## Security Best Practices

### ✅ DO:
1. **Always use middleware on routes** - This is your primary security
2. **Use authorization in controller methods** - Double protection
3. **Hide UI elements based on privileges** - Better UX
4. **Check privileges on AJAX endpoints** - API security
5. **Log privilege violations** - Security auditing

### ❌ DON'T:
1. **Don't rely only on hiding buttons** - Users can still access URLs
2. **Don't skip middleware** - Always protect routes
3. **Don't hardcode privilege checks** - Use the service/helpers
4. **Don't forget API routes** - Protect them too
5. **Don't expose privilege data unnecessarily** - Only send what's needed

## Testing Privileges

### Create Test User with Limited Privileges

```sql
-- Create a test user
INSERT INTO tbl_user (name, username, password, status, tbl_user_type_idtbl_user_type, updatedatetime)
VALUES ('Test User', 'testuser', MD5('password123'), 1, 1, NOW());

-- Get the user ID
SET @userId = LAST_INSERT_ID();

-- Grant only 'view' and 'edit' privileges for customers (menu ID 7)
INSERT INTO tbl_user_privilege 
(add, edit, statuschange, remove, access_status, status, updatedatetime, tbl_user_idtbl_user, tbl_menu_list_idtbl_menu_list)
VALUES (0, 1, 0, 0, 1, 1, NOW(), @userId, 7);
```

### Test Cases

1. **Login as test user**
2. **Try to access customer page** - Should work
3. **Try to edit a customer** - Should work
4. **Try to add a customer** - Should be blocked (no Add button, route blocked)
5. **Try to delete a customer** - Should be blocked (no Delete button, route blocked)
6. **Try direct URL access** - Should redirect with error message

## Troubleshooting

### Issue: "Unauthorized action" even with correct privileges

**Check:**
1. User is logged in: `auth()->check()`
2. Privilege record exists in database
3. `access_status` = 1
4. `status` = 1
5. Action column value = 1
6. Menu ID is correct

### Issue: Blade helpers not working

**Solution:**
```bash
composer dump-autoload
php artisan config:clear
php artisan cache:clear
```

### Issue: Middleware not working

**Check:**
1. Middleware is registered in `app/Http/Kernel.php`
2. Middleware alias is 'privilege'
3. Route syntax is correct: `->middleware('privilege:menuId,action')`

## Migration from Legacy System

To migrate your existing privilege data:

1. Your database structure is already compatible
2. Update controller methods to use new authorization
3. Add middleware to routes
4. Update Blade views with helper functions
5. Test each menu thoroughly

## Need Help?

Common scenarios:

**Q: Can I check multiple menus at once?**
A: Yes, use multiple middleware or check in controller:
```php
authorizePrivilege(7); // Customer menu
authorizePrivilege(9); // Product menu
```

**Q: Can I create custom privilege types?**
A: Yes, add columns to `tbl_user_privilege` and update the service.

**Q: How do I handle super admin?**
A: Check user type in middleware or add admin role check:
```php
if (auth()->user()->tbl_user_type_idtbl_user_type == 1) {
    return $next($request); // Admin bypass
}
```

**Q: Can I use this with API authentication?**
A: Yes, use Sanctum middleware:
```php
Route::middleware(['auth:sanctum', 'privilege:7'])->group(function () {
    // API routes
});
```
