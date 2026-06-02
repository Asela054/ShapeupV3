<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use DB;
use Illuminate\Http\Request;

class OutstandingForRepController extends Controller
{
public function index(Request $request)
{
    $empId = $request->empId;

    $sql = Invoice::query()
        ->leftJoin('tbl_invoice_payment_has_tbl_invoice as pay', 
            'pay.tbl_invoice_idtbl_invoice', '=', 'tbl_invoice.idtbl_invoice')
        ->select(
            'tbl_invoice.tbl_customer_idtbl_customer',
            DB::raw('MAX(tbl_invoice.invoiceno) as invoiceno'),
            DB::raw('SUM(tbl_invoice.nettotal) as fulltot'),
            DB::raw('COALESCE(SUM(pay.payamount),0) as payedamount')
        )
        ->where('tbl_invoice.status', 1)
        ->where('tbl_invoice.paymentcomplete', 0)
        ->whereHas('order', function($q) use($empId) {
            $q->where('tbl_user_idtbl_user', $empId)
              ->where('delivered', 1);
        })
        ->with('customer:idtbl_customer,name,address')
        ->groupBy('tbl_invoice.tbl_customer_idtbl_customer')
        ->orderBy('tbl_invoice.tbl_customer_idtbl_customer','desc')
        ->get();

    $result = $sql->map(function ($invoice) {
        return [
            'customerId' => (string) $invoice->customer->idtbl_customer,
            'invoiceno' => $invoice->invoiceno,
            'customername' => $invoice->customer->name ?? '',
            'fulltot' => (string) number_format((float) $invoice->fulltot, 0, '.', ''),
            'payedamount' => (string) number_format((float) $invoice->payedamount, 0, '.', ''),
            'address' => $invoice->customer->address ?? ''
        ];
    });

    return response()->json($result, 200, [], JSON_UNESCAPED_SLASHES);
}
}
