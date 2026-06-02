<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Invoice;
use DB;
use Illuminate\Http\Request;

class AllCustomersController extends Controller
{
    public function index()
    {
        // Query 1: Get all active customers
        $customers = Customer::where('status', 1)
            ->get(['idtbl_customer', 'name', 'phone', 'address', 'creditlimit']);

        $customerIds = $customers->pluck('idtbl_customer')->toArray();

        // Query 2: Get last order for each customer
        $lastOrders = DB::table('tbl_customer_order')
            ->whereIn('tbl_customer_idtbl_customer', $customerIds)
            ->select('tbl_customer_idtbl_customer', DB::raw('MAX(idtbl_customer_order) as orderId'))
            ->groupBy('tbl_customer_idtbl_customer')
            ->get()
            ->keyBy('tbl_customer_idtbl_customer');

        $orderIds = $lastOrders->pluck('orderId')->values()->toArray();
        
        $orderDates = DB::table('tbl_customer_order')
            ->whereIn('idtbl_customer_order', $orderIds)
            ->select('idtbl_customer_order', 'tbl_customer_idtbl_customer', 'insertdatetime')
            ->get()
            ->keyBy('tbl_customer_idtbl_customer');

        // Query 3: Get all outstanding balances using Invoice model
        $outstandingData = Invoice::leftJoin('tbl_invoice_payment_has_tbl_invoice', 
                'tbl_invoice_payment_has_tbl_invoice.tbl_invoice_idtbl_invoice', '=', 'tbl_invoice.idtbl_invoice')
            ->whereIn('tbl_customer_idtbl_customer', $customerIds)
            ->where('tbl_invoice.status', 1)
            ->where('tbl_invoice.paymentcomplete', 0)
            ->groupBy('tbl_customer_idtbl_customer')
            ->select(
                'tbl_customer_idtbl_customer',
                DB::raw('COALESCE(SUM(tbl_invoice.total), 0) as totalAmount'),
                DB::raw('COALESCE(SUM(tbl_invoice_payment_has_tbl_invoice.payamount), 0) as payAmount')
            )
            ->get()
            ->keyBy('tbl_customer_idtbl_customer');

        // Query 4: Get last invoice for each customer using Invoice model
        $lastInvoices = Invoice::whereIn('tbl_customer_idtbl_customer', $customerIds)
            ->select('tbl_customer_idtbl_customer', DB::raw('MAX(idtbl_invoice) as lastInvoiceId'))
            ->groupBy('tbl_customer_idtbl_customer')
            ->get()
            ->keyBy('tbl_customer_idtbl_customer');

        $result = $customers->map(function ($customer) use ($orderDates, $outstandingData, $lastInvoices) {
            // Get last visit date from pre-loaded order data
            $lastVisit = '00/00/000';
            if ($orderDates->has($customer->idtbl_customer)) {
                $order = $orderDates->get($customer->idtbl_customer);
                if ($order && $order->insertdatetime) {
                    $lastVisit = date('Y-m-d', strtotime($order->insertdatetime));
                }
            }

            // Get outstanding from pre-loaded data
            $outstanding = $outstandingData->get($customer->idtbl_customer);
            $outstandingAmount = $outstanding 
                ? ($outstanding->totalAmount - $outstanding->payAmount)
                : 0;

            // Get last invoice from pre-loaded data
            $lastInvNo = $lastInvoices->get($customer->idtbl_customer)?->lastInvoiceId ?? '0';

            return [
                'id' => (string) $customer->idtbl_customer,
                'shop_name' => $customer->name,
                'mobile' => $customer->phone,
                'address' => $customer->address,
                'creditlimit' => (string) $customer->creditlimit,
                'outStanding' => (string) $outstandingAmount,
                'visitStatus' => '1',
                'LastVisitDate' => $lastVisit,
                'lastInvNo' => (string) $lastInvNo
            ];
        })->values();

        return response()->json($result);
    }
}
