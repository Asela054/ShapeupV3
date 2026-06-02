<?php

use App\Http\Controllers\VATController;
use Illuminate\Support\Facades\Route;

// VAT Info routes
Route::get('/vat',          [VATController::class, 'index'])->name('vat.index');
Route::get('/data',      [VATController::class, 'getMatrixData'])->name('vat.data');
Route::post('/vat',         [VATController::class, 'store'])->name('vat.store');
Route::get('/vat/{id}',      [VATController::class, 'show'])->name('vat.show');
Route::put('/vat/{id}',      [VATController::class, 'update'])->name('vat.update');
Route::post('/vat/{id}/status', [VATController::class, 'updateStatus'])->name('vat.status');
Route::delete('/vat/{id}',   [VATController::class, 'destroy'])->name('vat.destroy');
