<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use DB;
use Illuminate\Http\Request;

class OutstandingForRepViseCustomerController extends Controller
{
    public function index(Request $request){
        $empId = $request->empId;
        $customerId = $request->customerId;

        $invoices = Invoice::with([
            'customer:idtbl_customer,customer,address',
            'order:idtbl_customer_order,tbl_user_idtbl_user,delivered,date',
            'order.deliveryData:idtbl_customer_order_delivery_data,tbl_customer_order_idtbl_customer_order,deliverDate'
        ])
        ->withSum('hasInvoicePayment as totalPaid', 'payamount')
        ->where('status', 1)
        ->where('paymentcomplete', 0)
        ->where('tbl_customer_idtbl_customer', $customerId)
        ->whereHas('order',function($q) use($empId){
            $q->where('tbl_user_idtbl_user', $empId)
              ->where('delivered', 1);
        })
        ->select(
    'idtbl_invoice',
            'tbl_customer_idtbl_customer',
            'invoiceno',
            'nettotal',
            'tbl_customer_order_idtbl_customer_order'
        )
        ->orderByDesc('date')
        ->get();

    $result = $invoices->map(function ($invoice) {
            return [
                'customerId' => (string) $invoice->tbl_customer_idtbl_customer,
                'invoiceno' => $invoice->invoiceno,
                'customername' => $invoice->customer->customer ?? $invoice->customer->name ?? '',
                'fulltot' => (string) number_format((float) $invoice->nettotal, 2, '.', ''),
                'payedamount' => (string) number_format((float) $invoice->totalPaid, 2, '.', ''),
                'address' => $invoice->customer->address ?? '',
                'date' => $invoice->order->date ?? '',
                'deliverDate' => $invoice->order->deliveryData->deliverDate ?? ''
            ];
        });

        return response()->json($result, 200, [], JSON_UNESCAPED_SLASHES);
    }
}
