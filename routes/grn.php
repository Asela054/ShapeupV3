<?php
use App\Http\Controllers\GRN\AllReturnController;
use App\Http\Controllers\GRN\GrnController;
use App\Http\Controllers\GRN\PaymentController;
use App\Http\Controllers\GRN\ReturnController;
use Illuminate\Support\Facades\Route;

Route::get('grn/purchase-orders/{id}', [GrnController::class, 'purchaseOrderDetails'])
	->whereNumber('id')
	->name('grn.purchase-order-details');
Route::get('grn/purchase-orders', [GrnController::class, 'listPurchaseOrders'])->name('grn.purchase-orders');
Route::get('grn-data', [GrnController::class, 'getData'])->name('grn.data');
Route::post('grn/{id}/confirm', [GrnController::class, 'confirm'])->name('grn.confirm');
Route::post('grn/{id}/transfer', [GrnController::class, 'transfer'])->name('grn.transfer');
Route::get('grn/{id}/pdf', [GrnController::class, 'pdf'])->name('grn.pdf');
Route::resource('grn',GrnController::class);

Route::get('payment/data', [PaymentController::class, 'paymentData'])->name('payment.data');
Route::get('payment/history', [PaymentController::class, 'history'])->name('payment.history');
Route::post('payment/history/data', [PaymentController::class, 'historyData'])->name('payment.history.data');
Route::get('payment/history/pdf', [PaymentController::class, 'historyPdf'])->name('payment.history.pdf');
Route::post('payment/history/detail', [PaymentController::class, 'historyDetail'])->name('payment.history.detail');
Route::get('payment/history/{payment}/{grn}/pdf', [PaymentController::class, 'historyDetailPdf'])->name('payment.history.detail.pdf');
Route::resource('payment', PaymentController::class);

Route::get('grnreturn/grns', [ReturnController::class, 'getGRN'])->name('grnreturn.grns');
Route::get('grnreturn/grn-details', [ReturnController::class, 'getGRNDetails'])->name('grnreturn.grn-details');
Route::resource('grnreturn', ReturnController::class);

Route::get('allgrnreturn/data', [AllReturnController::class, 'getData'])->name('allgrnreturn.data');
Route::get('allgrnreturn/detail/{id}', [AllReturnController::class, 'getDetail'])->name('allgrnreturn.detail');
Route::put('allgrnreturn/detail/{id}', [AllReturnController::class, 'updateDetail'])->name('allgrnreturn.detail.update');
Route::put('allgrnreturn/{id}/update-date', [AllReturnController::class, 'updateDate'])->name('allgrnreturn.update-date');
Route::post('allgrnreturn/{id}/accept', [AllReturnController::class, 'accept'])->name('allgrnreturn.accept');
Route::get('allgrnreturn/{id}', [AllReturnController::class, 'show'])->name('allgrnreturn.show');
Route::get('allgrnreturn', [AllReturnController::class, 'index'])->name('allgrnreturn.index');