<?php

use App\Http\Controllers\VehicleLoadingController;
use Illuminate\Support\Facades\Route;

// Product Routes (define these FIRST to avoid conflicts)
Route::get('/product/search', [VehicleLoadingController::class, 'search'])->name('product.search');
Route::get('/product/details/{id}', [VehicleLoadingController::class, 'getDetails'])->name('product.details');

// Vehicle Loading Routes
Route::prefix('vehicleloading')->name('vehicleloading.')->group(function () {
    Route::get('/', [VehicleLoadingController::class, 'index'])->name('index');
    Route::get('/list', [VehicleLoadingController::class, 'list'])->name('list');
    Route::post('/', [VehicleLoadingController::class, 'store'])->name('store');
    Route::get('/available-vehicles', [VehicleLoadingController::class, 'getAvailableVehicles'])->name('available-vehicles');
    Route::get('/available-employees', [VehicleLoadingController::class, 'getAvailableEmployees'])->name('available-employees');
    Route::get('/{id}/details', [VehicleLoadingController::class, 'getLoadingDetails'])->name('details');
    Route::post('/{id}/add-more', [VehicleLoadingController::class, 'addMoreItems'])->name('add-more');
    Route::post('/{id}/unload', [VehicleLoadingController::class, 'unload'])->name('unload');
});