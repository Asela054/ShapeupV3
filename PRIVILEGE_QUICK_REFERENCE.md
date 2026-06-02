# Privilege System - Quick Reference

## ⚡ Quick Start

### 1. In Routes (REQUIRED for security)
```php
// Protect entire route - check menu access only
Route::get('/customer', [CustomerController::class, 'index'])
    ->middleware('privilege:7');

// Protect with specific action
Route::post('/customer', [CustomerController::class, 'store'])
    ->middleware('privilege:7,add');

Route::put('/customer/{id}', [CustomerController::class, 'update'])
    ->middleware('privilege:7,edit');

Route::patch('/customer/{id}/status', [CustomerController::class, 'updateStatus'])
    ->middleware('privilege:7,statuschange');

Route::delete('/customer/{id}', [CustomerController::class, 'destroy'])
    ->middleware('privilege:7,remove');
```

### 2. In Controller
```php
// Auto-abort if no permission
authorizePrivilege(7);          // Check menu access
authorizePrivilege(7, 'add');   // Check specific action

// Manual check with custom response
if (!checkPrivilege(7, 'add')) {
    return redirect()->back()->with('error', 'No permission');
}
```

### 3. In Blade Views
```blade
{{-- Show/hide buttons based on privileges --}}
@if(checkPrivilege(7, 'add'))
    <button>Add Customer</button>
@endif

@if(checkPrivilege(7, 'edit'))
    <button>Edit</button>
@endif

@if(checkPrivilege(7, 'statuschange'))
    <button>Toggle Status</button>
@endif

@if(checkPrivilege(7, 'remove'))
    <button>Delete</button>
@endif

{{-- Check menu access --}}
@if(canAccessMenu(7))
    <a href="{{ route('customer.index') }}">Customers</a>
@endif

{{-- Check multiple privileges --}}
@if(hasAnyPrivilege(7, ['edit', 'remove']))
    <div>Show actions column</div>
@endif
```

### 4. In JavaScript
```javascript
// Get privileges as JSON
fetch('/api/privileges/7')
    .then(response => response.json())
    .then(privileges => {
        if (privileges.add) {
            // Show add button
        }
        if (privileges.edit) {
            // Show edit button
        }
    });
```

## 📋 Helper Functions

| Function | Purpose | Example |
|----------|---------|---------|
| `checkPrivilege($menuId, $action)` | Check specific privilege | `checkPrivilege(7, 'add')` |
| `canAccessMenu($menuId)` | Check menu access | `canAccessMenu(7)` |
| `authorizePrivilege($menuId, $action)` | Authorize or abort 403 | `authorizePrivilege(7, 'edit')` |
| `getMenuPrivileges($menuId)` | Get all privileges as array | `getMenuPrivileges(7)` |
| `hasAnyPrivilege($menuId, $actions)` | Has ANY privilege | `hasAnyPrivilege(7, ['edit', 'remove'])` |
| `hasAllPrivileges($menuId, $actions)` | Has ALL privileges | `hasAllPrivileges(7, ['edit', 'add'])` |
| `getUserAccessibleMenus()` | Get all accessible menus | `getUserAccessibleMenus()` |

## 🔒 Action Types

| Action | Database Column | Purpose |
|--------|----------------|---------|
| `add` | `add` | Create new records |
| `edit` | `edit` | Modify existing records |
| `statuschange` | `statuschange` | Change active/inactive status |
| `remove` | `remove` | Delete records |

## 🎯 Menu IDs (Legacy System Reference)

| ID | Page | Module |
|----|------|--------|
| 1 | User Accounts | User Management |
| 2 | User Types | User Management |
| 3 | User Privileges | User Management |
| 7 | Customers | Master Data |
| 8 | Suppliers | Master Data |
| 9 | Products | Master Data |
| 10 | Product Categories | Master Data |
| 15 | Purchase Orders | Purchasing |
| 16 | GRN | Purchasing |
| 18 | Invoice View | Sales |
| 19 | Invoice Payment | Sales |
| 27 | Employees | HR |
| 28 | Areas | Master Data |
| 47 | Sales Managers | Sales |

## ✅ Security Checklist

- [ ] Middleware added to ALL routes
- [ ] Authorization check in controller methods
- [ ] Blade directives for UI elements
- [ ] AJAX endpoints protected
- [ ] API routes secured
- [ ] Tested with restricted user account

## 🚀 Common Patterns

### Pattern 1: Full CRUD Protection
```php
Route::middleware(['auth'])->prefix('customer')->group(function () {
    Route::get('/', [CustomerController::class, 'index'])
        ->middleware('privilege:7');
    Route::post('/', [CustomerController::class, 'store'])
        ->middleware('privilege:7,add');
    Route::put('/{id}', [CustomerController::class, 'update'])
        ->middleware('privilege:7,edit');
    Route::patch('/{id}/status', [CustomerController::class, 'updateStatus'])
        ->middleware('privilege:7,statuschange');
    Route::delete('/{id}', [CustomerController::class, 'destroy'])
        ->middleware('privilege:7,remove');
});
```

### Pattern 2: Controller Method Protection
```php
public function store(Request $request)
{
    authorizePrivilege(7, 'add');
    
    // Your code here
}
```

### Pattern 3: Conditional UI
```blade
<table>
    <tr>
        @if(hasAnyPrivilege(7, ['edit', 'remove']))
            <th>Actions</th>
        @endif
    </tr>
    @foreach($customers as $customer)
        <tr>
            @if(hasAnyPrivilege(7, ['edit', 'remove']))
                <td>
                    @if(checkPrivilege(7, 'edit'))
                        <button>Edit</button>
                    @endif
                    @if(checkPrivilege(7, 'remove'))
                        <button>Delete</button>
                    @endif
                </td>
            @endif
        </tr>
    @endforeach
</table>
```

### Pattern 4: Get Privileges for Frontend
```php
public function index()
{
    $customers = Customer::all();
    $privileges = getMenuPrivileges(7);
    
    return view('customer.index', compact('customers', 'privileges'));
}
```

```blade
<script>
    const privileges = @json($privileges);
    
    if (privileges.add) {
        // Enable add functionality
    }
</script>
```

## ⚠️ Remember

1. **Middleware is REQUIRED** - Hiding buttons is NOT security
2. **Always use both** - Route middleware + Blade directives
3. **Test thoroughly** - Create test user with limited access
4. **API protection** - Don't forget API endpoints
5. **Legacy fix** - Your old system only hid menus, this actually blocks access

## 🔧 Troubleshooting

**Helpers not working?**
```bash
composer dump-autoload
php artisan config:clear
php artisan cache:clear
```

**Still getting "Unauthorized" with correct privileges?**
- Check database: `access_status` = 1 and `status` = 1
- Verify menu ID matches your database
- Ensure action column (add/edit/statuschange/remove) = 1
- Check user is authenticated

**Middleware not working?**
- Verify registered in `app/Http/Kernel.php`
- Check alias is 'privilege'
- Syntax: `->middleware('privilege:menuId,action')`
