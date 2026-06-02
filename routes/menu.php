<?php
use App\Http\Controllers\MenuController;
use Illuminate\Support\Facades\Route;

    Route::resource('menu', MenuController::class);

    Route::get('get-data', [MenuController::class, 'getdata'])
        ->name('menu.data');

    Route::post('menu/{id}/status', [MenuController::class, 'updateStatus'])
        ->name('menu.status');