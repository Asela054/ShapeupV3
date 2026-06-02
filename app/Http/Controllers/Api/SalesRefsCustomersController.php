<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

class SalesRefsCustomersController extends Controller
{
    public function index(Request $request)
    {
        // Get global tax rate
        $taxRate = DB::table('tbl_tax')->first('rate')->rate ?? 0;

        // Eager load all unpaid invoices for the customers
        $customers = Customer::with(['invoices' => function ($query) {
                $query->where('paymentcomplete', 0)
                      ->where('status', 1);
            }])
            ->where('status', 1)
            ->where('ref', $request->employeeId)
            ->get();

        $result = [];

        foreach ($customers as $customer) {

            // VAT logic
            $vat_cus = !empty($customer->vat_num);
            $tax_rate = $vat_cus ? $taxRate : 0;

            // Default values if no invoices
            $maxDateDiff = null;
            $invoiceId = null;
            $haveOutstanding = 0;

            // Compute maximum overdue and outstanding
            if ($customer->invoices->count() > 0) {
                foreach ($customer->invoices as $invoice) {
                    $diff = Carbon::now()->diffInDays(Carbon::parse($invoice->date));

                    // Track the maximum date difference
                    if (is_null($maxDateDiff) || $diff > $maxDateDiff) {
                        $maxDateDiff = $diff;
                        $invoiceId = $invoice->idtbl_invoice;
                    }

                    // Determine if the customer has an outstanding
                    if ($diff >= 90 && $customer->enable_for_porder == 0) {
                        $haveOutstanding = 1;
                    }
                }
            }

            $result[] = [
                "id" => (string)$customer->idtbl_customer,
                "name" => $customer->customer ?? $customer->name,
                "nic" => $customer->nic,
                "phone" => $customer->phone,
                "email" => $customer->email,
                "address" => $customer->address,
                "areaId" => (string)$customer->tbl_area_idtbl_area,
                "haveOutstanding" => $haveOutstanding,
                "isenable" => (string)$customer->enable_for_porder,
                "maxDateDiff" => $maxDateDiff !== null ? (string)$maxDateDiff : null,
                "invoiceId" => $invoiceId !== null ? (string)$invoiceId : null,
                "vat_cus" => $vat_cus,
                "tax_rate" => $tax_rate
            ];
        }

        return response()->json($result);
    }
}