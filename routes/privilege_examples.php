<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserAccountController;

/*
|--------------------------------------------------------------------------
| Privilege-Protected Routes Examples
|--------------------------------------------------------------------------
|
| This file demonstrates how to protect routes using the privilege middleware.
| Based on your legacy system's menubar.php privilege checking.
|
| Middleware usage: middleware('privilege:menuId,action')
| - menuId: The menu ID from tbl_menu_list
| - action: Optional. One of: add, edit, statuschange, remove
|
| If action is omitted, only access to the menu is checked.
| If action is specified, that specific permission is required.
|
*/

// Menu IDs (from your legacy system menubar.php)
// 1  = useraccount.php
// 2  = usertype.php
// 3  = userprivilege.php
// 4  = locations.php
// 7  = customer.php
// 8  = supplier.php
// 9  = product.php
// 10 = productcategory.php
// ... and so on

/*
|--------------------------------------------------------------------------
| PATTERN 1: Resource Controller with Full Privilege Control
|--------------------------------------------------------------------------
*/

// Customer Routes (Menu ID: 7)
Route::middleware(['auth'])->group(function () {
    // List customers - requires access to menu
    Route::get('/customer', [CustomerController::class, 'index'])
        ->name('customer.index')
        ->middleware('privilege:7');

    // Show add form - requires 'add' privilege
    Route::get('/customer/create', [CustomerController::class, 'create'])
        ->name('customer.create')
        ->middleware('privilege:7,add');

    // Store new customer - requires 'add' privilege
    Route::post('/customer', [CustomerController::class, 'store'])
        ->name('customer.store')
        ->middleware('privilege:7,add');

    // Show single customer - requires access to menu
    Route::get('/customer/{id}', [CustomerController::class, 'show'])
        ->name('customer.show')
        ->middleware('privilege:7');

    // Show edit form - requires 'edit' privilege
    Route::get('/customer/{id}/edit', [CustomerController::class, 'edit'])
        ->name('customer.edit')
        ->middleware('privilege:7,edit');

    // Update customer - requires 'edit' privilege
    Route::put('/customer/{id}', [CustomerController::class, 'update'])
        ->name('customer.update')
        ->middleware('privilege:7,edit');

    // Change status - requires 'statuschange' privilege
    Route::patch('/customer/{id}/status', [CustomerController::class, 'updateStatus'])
        ->name('customer.status')
        ->middleware('privilege:7,statuschange');

    // Delete customer - requires 'remove' privilege
    Route::delete('/customer/{id}', [CustomerController::class, 'destroy'])
        ->name('customer.destroy')
        ->middleware('privilege:7,remove');
});

/*
|--------------------------------------------------------------------------
| PATTERN 2: Grouped Routes with Common Privilege
|--------------------------------------------------------------------------
*/

// Supplier Routes (Menu ID: 8) - All routes require menu access
Route::middleware(['auth', 'privilege:8'])->prefix('supplier')->name('supplier.')->group(function () {
    // These routes only check menu access
    Route::get('/', [SupplierController::class, 'index'])->name('index');
    Route::get('/{id}', [SupplierController::class, 'show'])->name('show');
    
    // These routes check specific actions
    Route::get('/create', [SupplierController::class, 'create'])
        ->middleware('privilege:8,add')->name('create');
    
    Route::post('/', [SupplierController::class, 'store'])
        ->middleware('privilege:8,add')->name('store');
    
    Route::get('/{id}/edit', [SupplierController::class, 'edit'])
        ->middleware('privilege:8,edit')->name('edit');
    
    Route::put('/{id}', [SupplierController::class, 'update'])
        ->middleware('privilege:8,edit')->name('update');
    
    Route::patch('/{id}/status', [SupplierController::class, 'updateStatus'])
        ->middleware('privilege:8,statuschange')->name('status');
    
    Route::delete('/{id}', [SupplierController::class, 'destroy'])
        ->middleware('privilege:8,remove')->name('destroy');
});

/*
|--------------------------------------------------------------------------
| PATTERN 3: Using Route Resource with Middleware
|--------------------------------------------------------------------------
*/

// Product Routes (Menu ID: 9)
Route::middleware(['auth', 'privilege:9'])->group(function () {
    // This protects all resource routes with menu access
    Route::resource('product', ProductController::class);
    
    // Additional specific action routes
    Route::patch('product/{id}/status', [ProductController::class, 'updateStatus'])
        ->middleware('privilege:9,statuschange')
        ->name('product.status');
});

// To protect specific resource actions, you can do:
Route::middleware(['auth'])->group(function () {
    Route::resource('product', ProductController::class)->only(['index', 'show'])
        ->middleware('privilege:9');
    
    Route::resource('product', ProductController::class)->only(['create', 'store'])
        ->middleware('privilege:9,add');
    
    Route::resource('product', ProductController::class)->only(['edit', 'update'])
        ->middleware('privilege:9,edit');
    
    Route::resource('product', ProductController::class)->only(['destroy'])
        ->middleware('privilege:9,remove');
});

/*
|--------------------------------------------------------------------------
| PATTERN 4: API Routes with Privilege Control
|--------------------------------------------------------------------------
*/

Route::middleware(['auth:sanctum'])->prefix('api')->group(function () {
    // Customer API (Menu ID: 7)
    Route::get('/customers', [CustomerController::class, 'apiIndex'])
        ->middleware('privilege:7');
    
    Route::post('/customers', [CustomerController::class, 'apiStore'])
        ->middleware('privilege:7,add');
    
    Route::get('/customers/{id}', [CustomerController::class, 'apiShow'])
        ->middleware('privilege:7');
    
    Route::put('/customers/{id}', [CustomerController::class, 'apiUpdate'])
        ->middleware('privilege:7,edit');
    
    Route::patch('/customers/{id}/status', [CustomerController::class, 'apiUpdateStatus'])
        ->middleware('privilege:7,statuschange');
    
    Route::delete('/customers/{id}', [CustomerController::class, 'apiDestroy'])
        ->middleware('privilege:7,remove');
    
    // Get user's privileges for a menu
    Route::get('/privileges/{menuId}', function ($menuId) {
        return response()->json(getMenuPrivileges($menuId));
    });
});

/*
|--------------------------------------------------------------------------
| PATTERN 5: User Account Management Routes (Menu ID: 1)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'privilege:1'])->prefix('useraccount')->name('useraccount.')->group(function () {
    Route::get('/', [UserAccountController::class, 'index'])->name('index');
    Route::get('/create', [UserAccountController::class, 'create'])
        ->middleware('privilege:1,add')->name('create');
    Route::post('/', [UserAccountController::class, 'store'])
        ->middleware('privilege:1,add')->name('store');
    Route::get('/{id}/edit', [UserAccountController::class, 'edit'])
        ->middleware('privilege:1,edit')->name('edit');
    Route::put('/{id}', [UserAccountController::class, 'update'])
        ->middleware('privilege:1,edit')->name('update');
    Route::patch('/{id}/status', [UserAccountController::class, 'updateStatus'])
        ->middleware('privilege:1,statuschange')->name('status');
    Route::delete('/{id}', [UserAccountController::class, 'destroy'])
        ->middleware('privilege:1,remove')->name('destroy');
});

/*
|--------------------------------------------------------------------------
| PATTERN 6: Multiple Middleware on Same Route
|--------------------------------------------------------------------------
*/

// Sometimes you might want to combine multiple checks
Route::get('/special-report', function () {
    // Your code here
})->middleware(['auth', 'privilege:34', 'verified', 'throttle:60,1']);

/*
|--------------------------------------------------------------------------
| IMPORTANT SECURITY NOTES
|--------------------------------------------------------------------------
|
| 1. ALWAYS use middleware on routes - don't rely only on hiding UI elements
|    Your legacy system only hid menus, which is NOT secure!
|
| 2. The privilege middleware blocks unauthorized access at the route level
|    This prevents direct URL access even if buttons are hidden
|
| 3. Always use both:
|    - Middleware on routes (backend protection)
|    - Blade directives in views (UI/UX)
|
| 4. For AJAX requests, always check privileges on the server side
|
| 5. Menu IDs should match your tbl_menu_list table
|
| 6. Action names must be exactly: 'add', 'edit', 'statuschange', 'remove'
|    (matching your tbl_user_privilege column names)
|
*/
