<?php

use App\Http\Controllers\LocationController;
use Illuminate\Support\Facades\Route;


Route::get('/',                             [LocationController::class, 'index'])->name('location.index');
Route::get('/data',                         [LocationController::class, 'getLocationData'])->name('location.data');
Route::post('/',                            [LocationController::class, 'store'])->name('location.store');
Route::get('/{id}',                         [LocationController::class, 'show'])->name('location.show');
Route::put('/{id}',                         [LocationController::class, 'update'])->name('location.update');
Route::post('/{id}/status',                 [LocationController::class, 'updateStatus'])->name('location.status');
