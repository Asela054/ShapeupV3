<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HasInvoicePayment;
use Illuminate\Http\Request;

class PaymentSummeryController extends Controller
{
    public function index(Request $request){
        $sql = HasInvoicePayment::where('tbl_invoice_payment_idtbl_invoice_payment', $request->paymentinoiceID)
            ->get()
            ->map(function ($payment){
                return [
                    'id' => (string) $payment->tbl_invoice_idtbl_invoice,
                    'payamount' => (string) $payment->payamount
                ];
            });
        return response()->json($sql);
    }
}
