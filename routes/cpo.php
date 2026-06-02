<?php

use App\Http\Controllers\CPO\ConfirmedCPOController;
use App\Http\Controllers\CPO\DispatchedCPOController;
use App\Http\Controllers\CPO\DeliveredCPOController;
use App\Http\Controllers\CPO\CancelledCPOController;
use App\Http\Controllers\CPO\NewCPOController;
use Illuminate\Support\Facades\Route;

Route::get('newcpo-data', [NewCPOController::class, 'newcpoData'])->name('newcpo.data');

// Single cached lookup for all dropdown data
Route::get('newcpo/lookup-data', [NewCPOController::class, 'getLookupData'])->name('newcpo.lookupdata');

// Product endpoints 
Route::resource('newcpo', NewCPOController::class);
Route::get('newcpo/products/{commonName}', [NewCPOController::class, 'getProductsByCommonName'])->name('newcpo.products');
Route::get('newcpo/product-info/{id}', [NewCPOController::class, 'getProductInfo'])->name('newcpo.productinfo');
Route::get('newcpo/all-products', [NewCPOController::class, 'getAllProducts'])->name('newcpo.allproducts');
Route::post('newcpo/calculate-free-qty', [NewCPOController::class, 'calculateFreeQty'])->name('newcpo.calculatefreeqty');

// Actions
Route::post('newcpo/bulk-confirm', [NewCPOController::class, 'bulkConfirm'])->name('newcpo.bulkconfirm');
Route::post('newcpo/bulk-dispatch', [NewCPOController::class, 'bulkDispatch'])->name('newcpo.bulkdispatch');
Route::post('newcpo/bulk-deliver', [DispatchedCPOController::class, 'bulkDeliver'])->name('newcpo.bulkdeliver');
Route::post('newcpo/{id}/confirm', [NewCPOController::class, 'confirm'])->name('newcpo.confirm');
Route::post('newcpo/{id}/dispatch', [NewCPOController::class, 'dispatch'])->name('newcpo.dispatch');
Route::post('newcpo/{id}/deliver', [DispatchedCPOController::class, 'deliver'])->name('newcpo.deliver');
Route::post('newcpo/{id}/delivery-attempt', [DispatchedCPOController::class, 'recordDeliveryAttempt'])->name('newcpo.deliveryattempt');
Route::post('newcpo/{id}/reject-dispatch', [DispatchedCPOController::class, 'rejectDispatchedOrder'])->name('newcpo.rejectdispatch');
Route::post('newcpo/{id}/cancel', [NewCPOController::class, 'cancelOrder'])->name('newcpo.cancel');

// Order Detail Management
Route::post('newcpo/{id}/add-product', [NewCPOController::class, 'addProduct'])->name('newcpo.addproduct');
Route::put('newcpo/{id}/update-details', [NewCPOController::class, 'updateDetails'])->name('newcpo.updatedetails');

// Print Functions
Route::get('newcpo/{id}/print-order', [NewCPOController::class, 'printOrder'])->name('newcpo.printorder');
Route::get('newcpo/{id}/print-invoice', [NewCPOController::class, 'printInvoice'])->name('newcpo.printinvoice');

// Confirmed CPO routes
Route::get('confirmedcpo-data', [ConfirmedCPOController::class, 'confirmedcpoData'])->name('confirmedcpo.data');
Route::get('confirmedcpo', [ConfirmedCPOController::class, 'index'])->name('confirmedcpo.index');

// Dispatched CPO routes
Route::get('dispatchedcpo-data', [DispatchedCPOController::class, 'dispatchedcpoData'])->name('dispatchedcpo.data');
Route::get('dispatchedcpo', [DispatchedCPOController::class, 'index'])->name('dispatchedcpo.index');

// Delivered CPO routes
Route::get('deliveredcpo-data', [DeliveredCPOController::class, 'deliveredcpoData'])->name('deliveredcpo.data');
Route::get('deliveredcpo', [DeliveredCPOController::class, 'index'])->name('deliveredcpo.index');

// Cancelled CPO routes
Route::get('cancelledcpo-data', [CancelledCPOController::class, 'cancelledcpoData'])->name('cancelledcpo.data');
Route::get('cancelledcpo', [CancelledCPOController::class, 'index'])->name('cancelledcpo.index');