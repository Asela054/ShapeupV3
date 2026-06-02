<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::prefix('users')->name('users.')->group(function(){
    // user account routes
    Route::get('account', [UserController::class, 'index'])->name('account')->middleware('privilege:3');
    Route::post('register', [UserController::class, 'store'])->name('store')->middleware('privilege:3,add');
    Route::get('users-data', [UserController::class, 'getUsersData'])->name('data')->middleware('privilege:3');
    Route::get('{id}/edit', [UserController::class, 'edit'])->name('edit')->middleware('privilege:3,edit');
    Route::put('{id}', [UserController::class, 'update'])->name('update')->middleware('privilege:3,edit');
    Route::delete('{id}', [UserController::class, 'destroy'])->name('destroy')->middleware('privilege:3,remove');
    Route::post('{id}/status', [UserController::class, 'updateStatus'])->name('status')->middleware('privilege:3,statuschange');



    // user type routes

    Route::get('type', [UserController::class,'typeIndex'])->name('type')->middleware('privilege:2');
    Route::get('userstype-data', [UserController::class,'getUsertypeData'])->name('typedata')->middleware('privilege:2');
    Route::post('addusertype', [UserController::class,'addUserType'])->name('addusertype')->middleware('privilege:2,add');
    Route::get('typedata/{id}/edit', [UserController::class,'editUserType'])->name('usertype.edit')->middleware('privilege:2,edit');
    Route::post('typedata/{id}/status', [UserController::class, 'updateUserTypeStatus'])->name('usertype.editstatus')->middleware('privilege:2,statuschange');
    Route::put('typedata/{id}', [UserController::class, 'updateUserType'])->name('usertype.update')->middleware('privilege:2,edit');
    Route::delete('typedata/{id}', [UserController::class, 'destroyUserType'])->name('usertype.destroy')->middleware('privilege:2,remove');



    //privilege routes
    Route::get('privileges', [UserController::class,'privilegeIndex'])->name('privilege')->middleware('privilege:1');
    Route::get('privilege-data', [UserController::class,'getPrivilegeData'])->name('privilege.data')->middleware('privilege:1');
    Route::post('privileges/add', [UserController::class,'privilegeAdd'])->name('privilege.add')->middleware('privilege:1,add');
    Route::get('privilege/{id}/edit', [UserController::class, 'getPrivilege'])->name('privilege.get')->middleware('privilege:1,edit');
    Route::put('privilege/{id}', [UserController::class, 'editPrivilege'])->name('privilege.update')->middleware('privilege:1,edit');
    Route::post('privilege/{id}/status', [UserController::class, 'updatePrivilegeStatus'])->name('privilege.status')->middleware('privilege:1,statuschange');
    Route::delete('privilege/{id}/delete', [UserController::class, 'deletePrivilege'])->name('privilege.destroy')->middleware('privilege:1,remove');

});