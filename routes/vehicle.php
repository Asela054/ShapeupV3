<?php
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\VehicleLoadingController;
use Illuminate\Support\Facades\Route;

Route::resource('vehicles', VehicleController::class);
Route::get('vehicles-data', [VehicleController::class, 'getVehiclesData'])->name('vehicles.data');
Route::post('vehicles/{id}/status', [VehicleController::class, 'updateStatus'])->name('vehicles.status');
