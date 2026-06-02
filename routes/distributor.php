<?php

use App\Http\Controllers\DistributorController;
use App\Http\Controllers\DistributorCustomerController;
use App\Http\Controllers\DistributorcustomerpoController;
use App\Http\Controllers\DistributorGRNController;
use App\Http\Controllers\DistributorpoController;
use App\Http\Controllers\DistributorStockController;
use Illuminate\Support\Facades\Route;

//distributor routes
Route::resource('distributors', DistributorController::class);
Route::get('distributors-data', [DistributorController::class, 'getdata'])->name('distributors.data');
Route::post('/distributors/{id}/status', [DistributorController::class, 'updateStatus'])->name('distributors.status');
Route::get('/distributor/distributors/{id}/download-image', [DistributorController::class, 'downloadImage'])->name('distributors.downloadImage');

//distributor customer routes
Route::resource('distributorscustomers', DistributorCustomerController::class);
Route::get('distributorcustomers-data', [DistributorCustomerController::class, 'getdata'])->name('distributorscustomers.data');
Route::post('/distributorscustomers/{id}/status', [DistributorCustomerController::class, 'updateStatus'])->name('distributor-customers.status');
Route::get('/distributorscustomers/{id}/download-docs', [DistributorCustomerController::class, 'downloadDocs'])->name('distributor-customers.downloadDocs');

//distributor po routes
Route::get('/purchase-order', [DistributorpoController::class, 'index'])->name('distributor.po');
Route::get('/get-products', [DistributorpoController::class, 'productsearch'])->name('distributor.getproduct');
Route::post('/get-product-details', [DistributorpoController::class, 'getProductDetails'])->name('distributor.getproductdetails');
Route::post('/purchase-order/store', [DistributorpoController::class, 'store'])->name('distributor.po.store');
Route::get('/purchase-orders/list', [DistributorpoController::class, 'getPurchaseOrders'])->name('distributor.po.list');
Route::get('/purchase-order/edit', [DistributorpoController::class, 'edit'])->name('distributor.po.edit');
Route::post('/purchase-order/update-status', [DistributorpoController::class, 'updateStatus'])->name('distributor.po.updatestatus');
Route::post('/purchase-order/delete', [DistributorpoController::class, 'delete'])->name('distributor.po.delete');
Route::get('/purchase-order/print/{id}', [DistributorpoController::class, 'printPDF'])->name('distributor.po.print');
Route::post('/distributor/purchase-order/cancel', [DistributorpoController::class, 'cancelOrder'])->name('distributor.po.cancel');

//distributor grn routes
Route::get('/grn', [DistributorGRNController::class, 'index'])->name('distributor.grn');
Route::get('/list', [DistributorGRNController::class, 'list'])->name('distributor.grn.list');
Route::get('/getconfirmedpo', [DistributorGRNController::class, 'getConfirmedPO'])->name('distributor.grn.getconfirmedpo');
Route::get('/getpodetails', [DistributorGRNController::class, 'getPODetails'])->name('distributor.grn.getpodetails');
Route::post('/store', [DistributorGRNController::class, 'store'])->name('distributor.grn.store');
Route::get('/view', [DistributorGRNController::class, 'view'])->name('distributor.grn.view');
Route::post('/updatestatus', [DistributorGRNController::class, 'updateStatus'])->name('distributor.grn.updatestatus');
Route::post('/transferstock', [DistributorGRNController::class, 'transferStock'])->name('distributor.grn.transferstock');
Route::post('/delete', [DistributorGRNController::class, 'delete'])->name('distributor.grn.delete');
Route::get('/print/{id}', [DistributorGRNController::class, 'print'])->name('distributor.grn.print');

//distributor customer po routes
Route::get('/distributor/customers', [DistributorcustomerpoController::class, 'getCustomersByDistributor'])->name('distributor.customers');
Route::get('/customer/purchase-order', [DistributorcustomerpoController::class, 'porder'])->name('distributor.customer.po');
Route::post('submitpo', [DistributorcustomerpoController::class, 'submitporder'])->name('po.submit');
Route::get('/get-products-by-common-name', [DistributorcustomerpoController::class, 'getProductsByCommonName'])->name('product.bycommonname');
Route::get('/product/commonname/search',[DistributorcustomerpoController::class, 'commonnamesearch'])->name('product.commonname.search');
Route::get('/get-stock-qty', [DistributorcustomerpoController::class, 'getStockQty'])->name('product.stockqty');
Route::post('/distributor-customer/store', [DistributorcustomerpoController::class, 'store'])->name('distributor.customerpo.store');
Route::get('distributor-customerpo-list', [DistributorcustomerpoController::class, 'index'])->name('distributor.customerpo.index');
Route::post('/distributor-customerpo/confirm', [DistributorcustomerpoController::class, 'confirm'])->name('distributor.customerpo.confirm');
Route::post('/distributor-customerpo/cancel', [DistributorcustomerpoController::class, 'cancel'])->name('distributor.customerpo.cancel');
Route::get('/distributor-customerpo/show', [DistributorcustomerpoController::class, 'show'])->name('distributor.customerpo.show');
Route::post('/distributor-customerpo/update', [DistributorcustomerpoController::class, 'update'])->name('distributor.customerpo.update');
Route::get('/confirmed-purchase-orders', [DistributorcustomerpoController::class, 'confirmed'])->name('distributor.confirmed');
Route::get('/distributor-confirmedpo-list', [DistributorcustomerpoController::class, 'confirmedpo'])->name('distributor.confirmedpo');
Route::post('/distributor-customerpo/dispatch', [DistributorcustomerpoController::class, 'dispatch'])->name('distributor.customerpo.dispatch');
Route::get('/dispatched-purchase-orders', [DistributorcustomerpoController::class, 'dispatched'])->name('distributor.dispatched');
Route::get('/distributor-dispatchedpo-list', [DistributorcustomerpoController::class, 'dispatchedpo'])->name('distributor.dispatchedpo');
Route::post('/distributor-customerpo/deliver', [DistributorcustomerpoController::class, 'deliver'])->name('distributor.customerpo.deliver');
Route::get('/delivered-purchase-orders', [DistributorcustomerpoController::class, 'delivered'])->name('distributor.delivered');
Route::get('/distributor-deliveredpo-list', [DistributorcustomerpoController::class, 'deliveredpo'])->name('distributor.deliveredpo');
Route::get('/canceled-purchase-orders', [DistributorcustomerpoController::class, 'cancelled'])->name('distributor.cancelled');
Route::get('/distributor-canceledpo-list', [DistributorcustomerpoController::class, 'canceledpo'])->name('distributor.canceledpo');
Route::post('/customerpo/delete', [DistributorcustomerpoController::class, 'delete'])->name('distributor.customerpo.delete');
Route::post('/customerpo/calculate-price-distribution', [DistributorcustomerpoController::class, 'calculatePriceDistribution'])->name('distributor.customerpo.price-distribution');

//distributor stock adjustment routes
Route::get('/stock-adjustment', [DistributorStockController::class, 'index'])->name('distributor.stock.adjustment');
Route::get('/stock/distributors', [DistributorStockController::class, 'getDistributors'])->name('distributor.stock.getdistributors');
Route::get('/stock/list', [DistributorStockController::class, 'getStockList'])->name('distributor.stock.list');
Route::get('/stock/summary', [DistributorStockController::class, 'getSummary'])->name('distributor.stock.summary');
Route::get('/stock/details', [DistributorStockController::class, 'getDetails'])->name('distributor.stock.details');
Route::post('/stock/add', [DistributorStockController::class, 'addStock'])->name('distributor.stock.add');
Route::post('/stock/reduce', [DistributorStockController::class, 'reduceStock'])->name('distributor.stock.reduce');
Route::post('/stock/delete', [DistributorStockController::class, 'deleteStock'])->name('distributor.stock.delete');
Route::get('/stock/report', [DistributorStockController::class, 'generateReport'])->name('distributor.stock.report');
Route::get('/stock/export', [DistributorStockController::class, 'exportCSV'])->name('distributor.stock.export');
Route::get('/stock/getproduct', [DistributorStockController::class, 'getProduct'])->name('distributor.stock.getproduct');
Route::get('/adjustments/list', [DistributorStockController::class, 'getAdjustmentList'])->name('distributor.stock.adjustmentlist');
Route::get('/adjustments/report', [DistributorStockController::class, 'generateAdjustmentReport'])->name('distributor.stock.adjustmentreport');


