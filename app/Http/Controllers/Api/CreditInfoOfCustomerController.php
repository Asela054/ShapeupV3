<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CreditInfoOfCustomerController extends Controller
{
    public function index(Request $request)
    {
        $today = Carbon::today();
        $customerId = $request->customerId;

        $customer = Customer::where('status', 1)
            ->where('idtbl_customer', $customerId)
            ->first(['credittype', 'creditperiod', 'emergencydate']);

        if (!$customer) {
            return response()->json(['error' => 'Customer not found'], 404);
        }

        // Emergency date check
        if ($customer->emergencydate == $today->toDateString()) {
            return response()->json(['status' => 0]);
        }

        // Credit Type 1
        if ($customer->credittype == 1) {

            $count = Invoice::where('tbl_customer_idtbl_customer', $customerId)
                ->where('status', 1)
                ->where('paymentcomplete', 0)
                ->count();

            return response()->json([
                'status' => $count > 2 ? 1 : 0
            ]);
        }

        // Credit Type 2
        if ($customer->credittype == 2) {

            $invoice = Invoice::where('tbl_customer_idtbl_customer', $customerId)
                ->where('status', 1)
                ->where('paymentcomplete', 0)
                ->latest('date')
                ->first();

            if ($invoice) {
                $days = Carbon::parse($invoice->date)->diffInDays($today);

                return response()->json([
                    'status' => $days > $customer->creditperiod ? 1 : 0
                ]);
            }

            return response()->json(['status' => 0]);
        }

        // Credit Type 3
        if ($customer->credittype == 3) {
            return response()->json(['status' => 0]);
        }

        return response()->json(['status' => 0]);
    }
}