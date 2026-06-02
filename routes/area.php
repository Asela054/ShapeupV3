<?php
use App\Http\Controllers\AreaController;
use Illuminate\Support\Facades\Route;


// Route::resource('areas', AreaController::class);
// Route::get('areas-data', [AreaController::class, 'getdata'])->name('areas.data');
// Route::post('areas/{id}/status', [AreaController::class, 'updateStatus'])->name('areas.status');


    Route::resource('areas', AreaController::class);

    Route::get('areas-data', [AreaController::class, 'getdata'])
        ->name('areas.data');

    Route::post('areas/{id}/status', [AreaController::class, 'updateStatus'])
        ->name('areas.status');