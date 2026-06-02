<?php

use App\Http\Controllers\Reports\invoicePaymentMethodController;
use App\Http\Controllers\Reports\itemRangeController;
use App\Http\Controllers\Reports\SalesReportController;
use App\Http\Controllers\Reports\StockController;
use App\Http\Controllers\Reports\InvoiceviseProfitController;
use App\Http\Controllers\Reports\ItemviseProfitController;
use App\Http\Controllers\Reports\AllPoController;
use App\Http\Controllers\Reports\OutstandingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// stock
Route::get('stockdata', [StockController::class, 'indexStock'])->name('reports.stock.data');
Route::get('stockpdf', [StockController::class, 'stockPdf'])->name('reports.stock.pdf');
Route::get('stockcsv', [StockController::class, 'stockCsv'])->name('reports.stock.csv');
Route::resource('stock', StockController::class);

// sales report
Route::prefix('salesreport')->name('reports.sale.')->group(function () {
    Route::get('salesreportdata', [SalesReportController::class, 'repstData'])->name('repdata');
    Route::get('customersdata', [SalesReportController::class, 'customersData'])->name('customersdata');
    Route::get('salesreport', [SalesReportController::class, 'index'])->name('report');
    Route::get('salesreport/data', [SalesReportController::class, 'show'])->name('data');
});

Route::prefix('invoiceviseprofit')->name('reports.invoiceviseprofit.')->group(function () {
    Route::get('/',    [InvoiceviseProfitController::class, 'index'])->name('index');
    Route::get('data', [InvoiceviseProfitController::class, 'getData'])->name('data');
    Route::get('pdf',  [InvoiceviseProfitController::class, 'exportPdf'])->name('pdf');
    Route::get('csv',  [InvoiceviseProfitController::class, 'exportCsv'])->name('csv');
});

Route::prefix('itemviseprofit')->name('reports.itemviseprofit.')->group(function () {
    Route::get('/',        [ItemviseProfitController::class, 'index'])->name('index');
    Route::get('products', [ItemviseProfitController::class, 'searchProducts'])->name('products');
    Route::get('data',     [ItemviseProfitController::class, 'getData'])->name('data');
    Route::get('pdf',      [ItemviseProfitController::class, 'exportPdf'])->name('pdf');
    Route::get('csv',      [ItemviseProfitController::class, 'exportCsv'])->name('csv');
});

Route::prefix('allpo')->name('reports.allpo.')->group(function () {
    Route::get('/',         [AllPoController::class, 'index'])->name('index');
    Route::get('customers', [AllPoController::class, 'searchCustomers'])->name('customers');
    Route::get('reps',      [AllPoController::class, 'searchReps'])->name('reps');
    Route::get('areas',     [AllPoController::class, 'searchAreas'])->name('areas');
    Route::get('data',      [AllPoController::class, 'getData'])->name('data');
    Route::get('pdf',       [AllPoController::class, 'exportPdf'])->name('pdf');
    Route::get('csv',       [AllPoController::class, 'exportCsv'])->name('csv');
});

Route::prefix('outstanding')->name('reports.outstanding.')->group(function () {
    Route::get('/',          [OutstandingController::class, 'index'])->name('index');
    Route::get('/data',      [OutstandingController::class, 'getData'])->name('data');
    Route::get('/pdf',       [OutstandingController::class, 'exportPdf'])->name('pdf');
    Route::get('/csv',       [OutstandingController::class, 'exportCsv'])->name('csv');
    Route::get('/customers', [OutstandingController::class, 'searchCustomers'])->name('customers');
    Route::get('/reps',      [OutstandingController::class, 'searchReps'])->name('reps');
});

Route::prefix('itemrange')->name('reports.itemrange.')->group(function () {
    Route::get('/',          [itemRangeController::class, 'index'])->name('index');
    Route::get('/data',      [itemRangeController::class, 'getData'])->name('data');
    Route::get('/pdf',       [itemRangeController::class, 'exportPdf'])->name('pdf');
    Route::get('/csv',       [itemRangeController::class, 'exportCsv'])->name('csv');
});
Route::prefix('invoicepaymentmethod')->name('reports.invoicepaymentmethod.')->group(function () {
    Route::get('/',          [invoicePaymentMethodController::class, 'index'])->name('index');
    Route::get('/data',      [invoicePaymentMethodController::class, 'getData'])->name('data');
    // Route::get('/pdf',       [invoicePaymentMethodController::class, 'exportPdf'])->name('pdf');
    // Route::get('/csv',       [invoicePaymentMethodController::class, 'exportCsv'])->name('csv');
});