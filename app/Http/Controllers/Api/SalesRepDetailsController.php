<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;

class SalesRepDetailsController extends Controller
{
    public function index(Request $request)
    {
       $salesManagerId = $request->input('salesmanagerid');

    $employees = Employee::leftJoin('tbl_customer_order as co', 'co.tbl_employee_idtbl_employee', '=', 'tbl_employee.idtbl_employee')
        ->leftJoin('tbl_invoice as i', 'i.tbl_customer_order_idtbl_customer_order', '=', 'co.idtbl_customer_order')
        ->leftJoin('tbl_invoice_payment_has_tbl_invoice as ip', 'ip.tbl_invoice_idtbl_invoice', '=', 'i.idtbl_invoice')
        ->where('tbl_employee.status', 1)
        ->where('tbl_user_type_idtbl_user_type', 7)
        ->where('tbl_sales_manager_idtbl_sales_manager', $salesManagerId)
        ->where('i.status', 1)
        ->where('i.paymentcomplete', 0)
        ->groupBy('tbl_employee.idtbl_employee')
        ->selectRaw('
            tbl_employee.idtbl_employee as id,
            tbl_employee.name,
            tbl_employee.phone,
            tbl_employee.address,
            COALESCE(SUM(i.idtbl_invoice), 0) as outstandingcount,
            COALESCE(SUM(i.nettotal),0) as totaloutstanding,
            COALESCE(SUM(ip.payamount),0) as totalpayed
        ')
        ->get();

    $result = $employees->map(function ($employee) {
        return [
            'id' => (string) $employee->id,
            'name' => (string) $employee->name,
            'phone' => (string) $employee->phone,
            'address' => (string) $employee->address,
            'outstandingcount' => (string) $employee->outstandingcount,
            'totaloutstanding' => (string) number_format((float) $employee->totaloutstanding, 2, '.', ''),
            'totalpayed' => (string) number_format((float) $employee->totalpayed, 2, '.', '')
        ];
    });

    return response()->json($result, 200, [], JSON_UNESCAPED_SLASHES);
    }
}