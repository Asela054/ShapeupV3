<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;

class ManagerWiseRepsDailySalesController extends Controller
{
    public function index(Request $request)
{
    $salesManagerId = $request->salesManagerId;
    $today = now()->toDateString();

    $data = DB::table('tbl_employee as e')
        ->where('e.tbl_sales_manager_idtbl_sales_manager', $salesManagerId)

        ->select([
            'e.idtbl_employee as empId',
            'e.name as empName',

            //  Daily Total
            DB::raw("(
                SELECT COALESCE(SUM(co.nettotal), 0)
                FROM tbl_customer_order co
                WHERE co.tbl_employee_idtbl_employee = e.idtbl_employee
                AND co.status = 1
                AND DATE(co.insertdatetime) = CURDATE()
            ) as dailytotal"),

            //  Monthly Total
            DB::raw("(
                SELECT COALESCE(SUM(co.nettotal), 0)
                FROM tbl_customer_order co
                WHERE co.tbl_employee_idtbl_employee = e.idtbl_employee
                AND co.status = 1
                AND MONTH(co.date) = MONTH(CURDATE())
                AND YEAR(co.date) = YEAR(CURDATE())
            ) as fulltotal"),

            //  Accepted Returns (Monthly)
            DB::raw("(
                SELECT COALESCE(SUM(r.total), 0)
                FROM tbl_return r
                WHERE r.tbl_employee_idtbl_employee = e.idtbl_employee
                AND r.status = 1
                AND r.acceptance_status = 1
                AND MONTH(r.returndate) = MONTH(CURDATE())
                AND YEAR(r.returndate) = YEAR(CURDATE())
            ) as acceptedReturns"),

            //  Outstanding Total
            DB::raw("(
                SELECT COALESCE(SUM(i.nettotal - COALESCE(p.total_payment, 0)), 0)
                FROM tbl_customer_order co
                INNER JOIN tbl_invoice i 
                    ON i.tbl_customer_order_idtbl_customer_order = co.idtbl_customer_order
                LEFT JOIN (
                    SELECT tbl_invoice_idtbl_invoice, SUM(payamount) as total_payment
                    FROM tbl_invoice_payment_has_tbl_invoice
                    GROUP BY tbl_invoice_idtbl_invoice
                ) p ON p.tbl_invoice_idtbl_invoice = i.idtbl_invoice
                WHERE co.tbl_employee_idtbl_employee = e.idtbl_employee
                AND co.status = 1
                AND co.delivered = 1
                AND i.status = 1
                AND i.paymentcomplete = 0
            ) as outstandingtotal"),
        ])
        ->get()
        ->map(function ($item) use ($today) {
            return [
                "empId" => (string) $item->empId,
                "empName" => $item->empName,
                "fulltotal" => (string) $item->fulltotal,
                "dailytotal" => (string) $item->dailytotal,
                "outstandingtotal" => (float) $item->outstandingtotal,
                "acceptedReturns" => (float) $item->acceptedReturns,
                "date" => $today,
            ];
        });

    return response()->json($data);
}
}
