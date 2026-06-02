<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HasInvoicePayment;
use App\Models\InvoicePayment;
use Illuminate\Http\Request;

class MainInvoiceController extends Controller
{
   public function index(Request $request)
{
    $data = HasInvoicePayment::whereHas('invoice', function ($q) use ($request) {
            $q->where('status', 1)
              ->where('tbl_customer_idtbl_customer', $request->cusId);
        })
        ->whereHas('payment', function ($q) {
            $q->where('status', 1);
        })
        ->with([
            'payment:idtbl_invoice_payment,date,payment,balance,status'
        ])
        ->get()
        ->unique('tbl_invoice_payment_idtbl_invoice_payment')
        ->map(function ($item) {
            return [
                'id' => (string) $item->payment->idtbl_invoice_payment,
                'date' => $item->payment->date,
                'payment' => (string) $item->payment->payment,
                'balance' => (string) $item->payment->balance,
                'status' => (string) $item->payment->status,
            ];
        })
        ->values();

    return response()->json($data);
}
}
