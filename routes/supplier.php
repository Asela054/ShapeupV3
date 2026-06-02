<?php

use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;


Route::resource('suppliers', SupplierController::class);
Route::get('suppliers-data', [SupplierController::class, 'getSuppliersData'])->name('suppliers.data');
Route::post('suppliers/{id}/status', [SupplierController::class, 'updateStatus'])->name('suppliers.status');

