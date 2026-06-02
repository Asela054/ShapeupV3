<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use DB;
use Illuminate\Http\Request;

class CustomerForPOrder extends Controller
{
    public function index()
    {
        $tax_rate = DB::table('tbl_tax')->value('rate') ?? 0;
        $customers = Customer::where('status', 1)->get(['idtbl_customer', 'customer']);
        
        $result = $customers->map(function ($customer) use ($tax_rate) {
            return [
                'id' => (string) $customer->idtbl_customer,
                'customername' => $customer->customer,
                'vat_cus' => false,
                'tax_rate' => 0, //legacy code always returns 0 for tax_rate in this endpoint, so  keep it as is
            ];
        })->values();

        return response()->json($result);
    }
}
