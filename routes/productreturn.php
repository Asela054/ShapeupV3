<?php

use App\Http\Controllers\ProductReturn\AllReturnController;
use App\Http\Controllers\ProductReturn\ReturnController;
use Illuminate\Support\Facades\Route;

// ─── New Product Return ───
Route::get('return/invoices', [ReturnController::class, 'getInvoices'])->name('productreturn.invoices');
Route::get('return/invoice-items', [ReturnController::class, 'getInvoiceItems'])->name('productreturn.invoice-items');
Route::get('return', [ReturnController::class, 'index'])->name('productreturn.index');
Route::post('return', [ReturnController::class, 'store'])->name('productreturn.store');

// ─── All Product Returns (Customer Return) ───
Route::get('allreturn/data', [AllReturnController::class, 'getData'])->name('productreturn.allreturn.data');
Route::get('allreturn/detail/{id}', [AllReturnController::class, 'getDetail'])->name('productreturn.allreturn.detail');
Route::put('allreturn/detail/{id}', [AllReturnController::class, 'updateDetail'])->name('productreturn.allreturn.detail.update');
Route::put('allreturn/{id}/update-date', [AllReturnController::class, 'updateDate'])->name('productreturn.allreturn.update-date');
Route::post('allreturn/{id}/accept', [AllReturnController::class, 'accept'])->name('productreturn.allreturn.accept');
Route::get('allreturn/{id}', [AllReturnController::class, 'show'])->name('productreturn.allreturn.show');
Route::get('allreturn', [AllReturnController::class, 'index'])->name('productreturn.allreturn.index');
