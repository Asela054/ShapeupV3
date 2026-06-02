<?php

use App\Http\Controllers\CancelledInvoiceController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoicepaymentController;
use App\Http\Controllers\PaymentreceiptController;
use Illuminate\Support\Facades\Route;

// Invoice
Route::prefix('invoices')->group(function () {
    Route::get('/',                              [InvoiceController::class, 'index'])          ->name('invoices.index');
    Route::get('/data',                          [InvoiceController::class, 'data'])           ->name('invoices.data');
    Route::get('/invoice/{id}',                  [InvoiceController::class, 'show'])           ->name('invoices.show');
    Route::get('/invoice/{id}/pdf',              [InvoiceController::class, 'pdf'])            ->name('invoices.pdf');
    Route::post('/invoice/{id}/delete',          [InvoiceController::class, 'delete'])         ->name('invoices.delete');
    Route::get('/invoice/{id}/payment-details',  [InvoiceController::class, 'paymentDetails']) ->name('invoices.payment_details');
    Route::get('/invoice/{id}/payment',          [InvoiceController::class, 'paymentPdf'])     ->name('invoices.payment_pdf'); 
    Route::get('/invoice/{id}/order-pdf',        [InvoiceController::class, 'orderPdf'])->name('invoices.order.pdf');
});

// Invoice Payment 
Route::get('/invoice-payment',                  [InvoicepaymentController::class, 'index'])           ->name('invoice-payment.index');
Route::get('/invoice-payment/get-customers',    [InvoicepaymentController::class, 'getCustomers'])    ->name('invoice-payment.get-customers');
Route::post('/invoice-payment/get-invoices',    [InvoicepaymentController::class, 'getInvoices'])     ->name('invoice-payment.get-invoices');
Route::post('/invoice-payment/get-credit-notes',[InvoicepaymentController::class, 'getCreditNotes'])  ->name('invoice-payment.get-credit-notes');
Route::get('/invoice-payment/get-banks',        [InvoicepaymentController::class, 'getBanks'])        ->name('invoice-payment.get-banks');
Route::post('/invoice-payment/process-payment', [InvoicepaymentController::class, 'processPayment'])  ->name('invoice-payment.process-payment');
Route::post('/invoice-payment/get-receipt',     [InvoicepaymentController::class, 'getReceipt'])      ->name('invoice-payment.get-receipt');

// Payment Receipt 
Route::get('/paymentreceipt',                   [PaymentreceiptController::class, 'index'])     ->name('paymentreceipt.index');
Route::post('/paymentreceipt/datatable',        [PaymentreceiptController::class, 'datatable']) ->name('paymentreceipt.datatable');
Route::post('/paymentreceipt/get-receipt',      [PaymentreceiptController::class, 'getReceipt'])->name('paymentreceipt.get-receipt');
Route::delete('/paymentreceipt/delete/{id}',    [PaymentreceiptController::class, 'delete'])    ->name('paymentreceipt.delete');

//Cancelled Invoice
Route::get('/cancelledinvoice',                 [CancelledInvoiceController::class, 'index'])     ->name('cancelledinvoice.index');
Route::post('/cancelledinvoice/datatable',      [CancelledInvoiceController::class, 'datatable']) ->name('cancelledinvoice.datatable');
Route::post('/cancelledinvoice/get-invoice',    [CancelledInvoiceController::class, 'getInvoice'])->name('cancelledinvoice.get-invoice');