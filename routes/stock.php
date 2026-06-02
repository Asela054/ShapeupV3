<?php

use App\Http\Controllers\StockAdjustmentController;
use Illuminate\Support\Facades\Route;

//stock adjustment routes
Route::get('/adjustment', [StockAdjustmentController::class, 'index'])->name('stock.adjustment');
Route::get('/adjustment/list', [StockAdjustmentController::class, 'list'])->name('stock.adjustment.list');
Route::get('/adjustment/product-search', [StockAdjustmentController::class, 'searchProducts'])->name('stock.adjustment.product-search');
Route::post('/adjustment/product', [StockAdjustmentController::class, 'getProduct'])->name('stock.adjustment.product');
Route::post('/adjustment/stock-data', [StockAdjustmentController::class, 'getStockData'])->name('stock.adjustment.stockdata');
Route::post('/adjustment', [StockAdjustmentController::class, 'store'])->name('stock.adjustment.store');
