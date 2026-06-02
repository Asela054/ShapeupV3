<?php

use App\Http\Controllers\SalesmanagerController;
use Illuminate\Support\Facades\Route;


Route::resource('salesmanagers', SalesmanagerController::class);
Route::get('salesmanagers-data', [SalesmanagerController::class, 'getSalesmanagersData'])->name('salesmanagers.data');
Route::post('salesmanagers/{id}/status', [SalesmanagerController::class, 'updateStatus'])->name('salesmanagers.status');
Route::get('/salesmanager/users/search',[SalesManagerController::class, 'search'])->name('salesmanager.users.search');



