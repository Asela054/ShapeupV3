<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CustomerAvailableQty;
use App\Models\CustomerAvailableQtyDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerAvailableQtyController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'usrId' => 'required|integer',
            'customerId' => 'required|integer',
            'rejectReason' => 'required|integer',
            'details' => 'required',
        ]);

        $details = $request->input('details');
        if (is_string($details)) {
            $details = json_decode($details, true);
        }

        if (!is_array($details)) {
            return response()->json(['code' => '500', 'message' => 'Update Not Complete'], 422);
        }

        try {
            DB::transaction(function () use ($validated, $details) {
                $header = CustomerAvailableQty::create([
                    'date' => $validated['date'],
                    'status' => 1,
                    'updatedatetime' => now(),
                    'tbl_user_idtbl_user' => $validated['usrId'],
                    'tbl_customer_idtbl_customer' => $validated['customerId'],
                    'tbl_reject_reason_idtbl_reject_reason' => $validated['rejectReason'],
                ]);

                foreach ($details as $item) {
                    CustomerAvailableQtyDetail::create([
                        'fullqty' => $item['shopFullQty'] ?? 0,
                        'emptyqty' => $item['shopEmptyQty'] ?? 0,
                        'bufferqty' => $item['bufferStock'] ?? 0,
                        'status' => 1,
                        'updatedatetime' => now(),
                        'tbl_user_idtbl_user' => $validated['usrId'],
                        'tbl_customer_ava_qty_idtbl_customer_ava_qty' => $header->idtbl_customer_ava_qty,
                        'tbl_product_idtbl_product' => $item['productId'] ?? 0,
                    ]);
                }
            });

            return response()->json(['code' => '200', 'message' => 'Update Complete']);
        } catch (\Throwable $e) {
            return response()->json(['code' => '500', 'message' => 'Update Not Complete'], 500);
        }
    }
}
