<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UnpaindInvoiceController extends Controller
{

public function index(Request $request)
{
    $data = DB::table('tbl_invoice')
        ->leftJoin(
            'tbl_invoice_payment_has_tbl_invoice',
            'tbl_invoice_payment_has_tbl_invoice.tbl_invoice_idtbl_invoice',
            '=',
            'tbl_invoice.idtbl_invoice'
        )
        ->where('tbl_invoice.tbl_customer_idtbl_customer', $request->customerID)
        ->where('tbl_invoice.status', 1)
        ->where('tbl_invoice.paymentcomplete', 0)
        ->select([
            DB::raw('CAST(tbl_invoice.idtbl_invoice AS CHAR) as invoice'),
            'tbl_invoice.date',
            DB::raw('CAST(tbl_invoice.total AS CHAR) as total'),
            DB::raw('CAST(COALESCE(tbl_invoice_payment_has_tbl_invoice.payamount, 0) AS CHAR) as payamount')
        ])
        ->get();

    return response()->json($data);
}
}
