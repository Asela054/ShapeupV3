<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CustomerPOrder;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\InvoicePaymentDetail;

class KpiDataController extends Controller
{
    public function index()
    {
        $salesMonth = (float) Invoice::query()
            ->where('status', '!=', 0)
            ->whereYear('date', now()->year)
            ->whereMonth('date', now()->month)
            ->sum('nettotal');

        $cashMonth = (float) InvoicePaymentDetail::query()
            ->join('tbl_invoice_payment as ip', 'ip.idtbl_invoice_payment', '=', 'tbl_invoice_payment_detail.tbl_invoice_payment_idtbl_invoice_payment')
            ->where('tbl_invoice_payment_detail.status', 1)
            ->whereIn('tbl_invoice_payment_detail.method', [1, 2])
            ->whereYear('ip.date', now()->year)
            ->whereMonth('ip.date', now()->month)
            ->sum('tbl_invoice_payment_detail.amount');

        $purchasesMonth = (float) CustomerPOrder::query()
            ->where('status', 1)
            ->whereYear('date', now()->year)
            ->whereMonth('date', now()->month)
            ->sum('nettotal');

        $profitBaseQuery = InvoiceDetail::query()
            ->selectRaw('COALESCE(SUM((tbl_invoice_detail.saleprice - tbl_invoice_detail.unitprice) * tbl_invoice_detail.qty), 0) as total_profit')
            ->join('tbl_invoice as i', 'i.idtbl_invoice', '=', 'tbl_invoice_detail.tbl_invoice_idtbl_invoice')
            ->join('tbl_customer_order as o', 'o.idtbl_customer_order', '=', 'i.tbl_customer_order_idtbl_customer_order')
            ->whereIn('o.status', [1, 2])
            ->where('o.delivered', 1)
            ->where('tbl_invoice_detail.status', 1);

        $profitMonth = (float) (clone $profitBaseQuery)
            ->whereYear('o.date', now()->year)
            ->whereMonth('o.date', now()->month)
            ->value('total_profit');

        $profitItem = (float) (clone $profitBaseQuery)
            ->value('total_profit');

        return response()->json([
            'sales_month' => $salesMonth,
            'cash_month' => $cashMonth,
            'purchases_month' => $purchasesMonth,
            'profit_month' => $profitMonth,
            'profit_item' => $profitItem,
        ]);
    }
}
