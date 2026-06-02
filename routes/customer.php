<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerTypeController;
use App\Http\Controllers\CustomerAssetController;
use Illuminate\Support\Facades\Route;


Route::resource('customers', CustomerController::class);
Route::get('customers-data', [CustomerController::class, 'getCustomersData'])->name('customers.data');
Route::post('customers/{id}/status', [CustomerController::class, 'updateStatus'])->name('customers.status');
Route::get('/customers/{id}/download-docs', [CustomerController::class, 'downloadDocs'])->name('customers.downloadDocs');
Route::post('/customers/bulk-update-rep', [CustomerController::class, 'bulkUpdateRep'])->name('customers.bulkUpdateRep');

Route::resource('customer-types', CustomerTypeController::class);
Route::get('customer-types-data', [CustomerTypeController::class, 'getCustomerTypesData'])->name('customer-types.data');
Route::post('/customer-types/{id}/status', [CustomerTypeController::class, 'updateStatus'])->name('customer-types.status');
Route::get('/customer-types/{id}/download-docs', [CustomerTypeController::class, 'downloadDocs'])->name('customer-types.downloadDocs');

Route::resource('customer-assets', CustomerAssetController::class);
Route::get('customer-assets-data', [CustomerAssetController::class, 'getCustomerAssetsData'])->name('customer-assets.data');
Route::post('/customer-assets/{id}/status', [CustomerAssetController::class, 'updateStatus'])->name('customer-assets.status');
Route::get('/customer-assets/{id}/download-docs', [CustomerAssetController::class, 'downloadDocs'])->name('customer-assets.downloadDocs');