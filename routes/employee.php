<?php

use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;


Route::resource('employees', EmployeeController::class);
Route::get('employees-data', [EmployeeController::class, 'getEmployeesData'])->name('employees.data');
Route::post('employees/{id}/status', [EmployeeController::class, 'updateStatus'])->name('employees.status');
Route::get('/salesmanager/search',[EmployeeController::class, 'salemanagersearch'])->name('salesmanager.search');
Route::get('/user/search',[EmployeeController::class, 'usersearch'])->name('user.search');
Route::get('/employeetype/search',[EmployeeController::class, 'employeetypesearch'])->name('employeetype.search');

