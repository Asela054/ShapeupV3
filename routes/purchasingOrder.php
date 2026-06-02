<?php

use App\Http\Controllers\GroupcategoryController;
use App\Http\Controllers\POrderController;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\PurchasingOrderController;


// Keep the specific utility routes above the resource so they aren't swallowed by the {purchaseorder} wildcard
Route::get('purchaseorders-data', [POrderController::class, 'getData'])->name('purchaseorders.data');
Route::get('purchaseorders/get-suppliersdetails',[POrderController::class, 'getSupplierDetails'])->name('purchaseorders.getsuppliersdetails');
Route::get('purchaseorders/get-productsdetails',[POrderController::class, 'getProductsDetails'])->name('purchaseorders.getproductsdetails');
Route::post('purchaseorders/{id}/status',[POrderController::class, 'updateStatus'])->name('purchaseorders.status');

Route::resource('purchaseorders', POrderController::class);

// Route::get('purchaseorders/{id}', [POrderController::class, 'getPODetails'])->name('purchaseorders.getpodetails');

// Route::get('purchaseorders/{id}/edit', [POrderController::class, 'edit'])->name('purchaseorders.edit');

Route::get('purchaseorders/{id}/pdf', [POrderController::class, 'pdf'])->name('purchaseorders.pdf');