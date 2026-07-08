<?php

use App\Http\Controllers\ActivitylogController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserTypeController;
use App\Http\Controllers\UserPrivilegeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// User Account Routes
Route::get('/userslist', [UserController::class, 'index'])->name('userslist');
Route::get('/users/data', [UserController::class, 'getUsersData'])->name('users.data');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
Route::post('/users/{id}/status', [UserController::class, 'updateStatus'])->name('users.status');

// User Type Routes
Route::get('/userstypelist', [UserTypeController::class, 'typeIndex'])->name('userstypelist');
Route::get('/users/typedata', [UserTypeController::class, 'getUsertypeData'])->name('users.typedata');
Route::post('/users/addusertype', [UserTypeController::class, 'addUserType'])->name('users.addusertype');
Route::get('/users/typedata/{id}/edit', [UserTypeController::class, 'editUserType'])->name('users.typedata.edit');
Route::put('/users/typedata/{id}', [UserTypeController::class, 'updateUserType'])->name('users.typedata.update');
Route::delete('/users/typedata/{id}', [UserTypeController::class, 'destroyUserType'])->name('users.typedata.destroy');
Route::post('/users/typedata/{id}/status', [UserTypeController::class, 'updateUserTypeStatus'])->name('users.typedata.status');

// User Privilege Routes
Route::get('/usersprivilegelist', [UserPrivilegeController::class, 'privilegeIndex'])->name('usersprivilegelist');
Route::get('/users/privilege/data', [UserPrivilegeController::class, 'getPrivilegeData'])->name('users.privilege.data');
Route::post('/users/privilege', [UserPrivilegeController::class, 'privilegeAdd'])->name('users.privilege.add');
Route::get('/users/privilege/{id}/edit', [UserPrivilegeController::class, 'getPrivilege'])->name('users.privilege.edit');
Route::put('/users/privilege/{id}', [UserPrivilegeController::class, 'editPrivilege'])->name('users.privilege.update');
Route::delete('/users/privilege/{id}/delete', [UserPrivilegeController::class, 'deletePrivilege'])->name('users.privilege.delete');
Route::post('/users/privilege/{id}/status', [UserPrivilegeController::class, 'updatePrivilegeStatus'])->name('users.privilege.status');

Route::get('/activitylog', [ActivitylogController::class, 'index'])->name('activitylog.index');
Route::get('/activitylog/{id}', [ActivitylogController::class, 'show'])->name('activitylog.show');

require __DIR__ . '/auth.php';
require __DIR__ . '/organization.php';
require __DIR__.'/employee_management.php';
