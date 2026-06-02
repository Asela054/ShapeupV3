<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerViceOutstandingForRepController extends Controller
{
    public function index(Request $request)
    {
        $empId = $request->empId;
        
        $customers = DB::table('tbl_invoice as i')
            ->join('tbl_customer_order as co', 'i.tbl_customer_order_idtbl_customer_order', '=', 'co.idtbl_customer_order')
            ->join('tbl_customer as c', 'i.tbl_customer_idtbl_customer', '=', 'c.idtbl_customer')
            ->leftJoin('tbl_invoice_payment_has_tbl_invoice as ip', 'ip.tbl_invoice_idtbl_invoice', '=', 'i.idtbl_invoice')
            ->select(
                'c.idtbl_customer',
                'c.customer',
                'c.address',
                DB::raw('MIN(co.date) as date'),
                DB::raw('COALESCE(SUM(i.nettotal),0) as totalamount'),
                DB::raw('COALESCE(SUM(ip.payamount),0) as totpayedamount'),
                DB::raw('MAX(DATEDIFF(CURDATE(), i.date)) as max_date_diff')
            )
            ->where('i.status', 1)
            ->where('i.paymentcomplete', 0)
            ->where('co.tbl_employee_idtbl_employee', $empId)
            ->where('co.delivered', 1)
            ->groupBy('c.idtbl_customer', 'c.customer', 'c.address')
            ->orderBy('c.customer')
            ->get()
            ->map(function($customer) {
                if ($customer->max_date_diff >= 90) {
                    $limit = 2;
                } elseif ($customer->max_date_diff >= 60) {
                    $limit = 1;
                } else {
                    $limit = 0;
                }

                return [
                    'customerId' => (string) $customer->idtbl_customer,
                    'customername' => $customer->name ?? $customer->customer ?? null,
                    'fulltot' => number_format($customer->totalamount, 2, '.', ''),
                    'payedamount' => number_format($customer->totpayedamount, 2, '.', ''),
                    'address' => $customer->address,
                    'date' => $customer->date,
                    'limit' => $limit,
                ];
            });

        return response()->json($customers);
    }
}