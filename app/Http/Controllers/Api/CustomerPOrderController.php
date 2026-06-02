<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CustomerPOrder;

class CustomerPOrderController extends Controller
{
    public function index(Request $request)
    {
        $repid = $request->input('repid', 0);
        $salesmanagerid = $request->input('salesmanagerid', 0);

        $query = CustomerPOrder::with([
            'details' => function ($q) {
                $q->where('status', 1)->with('product:idtbl_product,product_name');
            },
            'customer:idtbl_customer,customer,address',
            'area:idtbl_area,area',
            'invoices:idtbl_invoice,tbl_customer_order_idtbl_customer_order,paymentcomplete,date',
            'employee.salesmanager:idtbl_sales_manager'
        ])->where('status', 1);

        if ($repid != 0) {
            $query->where('tbl_employee_idtbl_employee', $repid);
        }

        if ($salesmanagerid != 0) {
            $query->whereHas('employee.salesmanager', function ($q) use ($salesmanagerid) {
                $q->where('idtbl_sales_manager', $salesmanagerid);
            });
        }

        $orders = $query->get();

        if ($orders->isEmpty()) {
            return response()->json([]);
        }

        $data = $orders->map(function ($order) {
            $invoice = $order->invoices; // relation is a hasOne, so this returns the invoice model or null

            $detaildata = $order->details->map(function ($detail) {
                return [
                    'orderqty' => (string) $detail->orderqty,
                    'saleprice' => (string) $detail->saleprice,
                    'total' => (string) $detail->total,
                    'discount' => (string) $detail->discount,
                    'product_name' => $detail->product->product_name ?? null,
                    'calctotal' => (string) ($detail->orderqty * $detail->saleprice),
                ];
            })->toArray(); // ensure all items are returned

            return [
                'data' => [
                    'paymentcomplete' => $invoice ? (string) $invoice->paymentcomplete : null,
                    'datediff' => $invoice ? (string) now()->diffInDays($invoice->date) : null,
                    'orderid' => (string) $order->idtbl_customer_order,
                    'date' => $order->date,
                    'status' => (string) $order->status,
                    'nettotal' => (string) $order->nettotal,
                    'remark' => $order->remark,
                    'customername' => $order->customer->name ?? $order->customer->customer ?? null,
                    'area' => $order->area->area ?? null,
                    'address' => $order->customer->address ?? null,
                ],
                'detaildata' => $detaildata
            ];
        });

        return response()->json($data);
    }
}