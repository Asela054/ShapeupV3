<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class RefsCustomersController extends Controller
{
    public function index(Request $request){
        $sql = Customer::where('status', 1)
            ->where('ref', $request->refId)
            ->where('tbl_area_idtbl_area', $request->areaid)
            ->get()
            ->map(function($customer){
                return [
                    'id' => (string) $customer->idtbl_customer,
                    'name' => $customer->customer ?? $customer->name,
                    'address' => $customer->address,
                    'areaId' => (string) $customer->tbl_area_idtbl_area
                ];
            });
        return response()->json($sql);
    }
}
