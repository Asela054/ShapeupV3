<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\VehicleLoading;
use Illuminate\Http\Request;

class VehicleLoadingDataController extends Controller
{
    public function show(Request $request)
    {
        $id = (int) $request->query('id', 0);

        if ($id <= 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid vehicle loading ID.',
            ], 422);
        }

        $loading = VehicleLoading::query()
            ->with([
                'details' => fn ($q) => $q
                    ->select([
                        'idtbl_vehicle_loading_details',
                        'tbl_vehicle_loading_idtbl_vehicle_loading',
                        'tbl_product_idtbl_product',
                        'qty',
                        'qty_remaining',
                    ])
                    ->with([
                        'product:idtbl_product,common_name',
                        'batches' => fn ($bq) => $bq
                            ->select([
                                'idtbl_vehicle_loading_details_batches',
                                'tbl_vehicle_loading_details_idtbl_vehicle_loading_details',
                                'tbl_batch_idtbl_batch',
                                'qty_from_batch',
                                'qty_returned',
                            ])
                            ->with('batchStock:idtbl_stock,batchno'),
                    ]),
            ])
            ->find($id);

        if (!$loading) {
            return response()->json([
                'status' => 'error',
                'message' => 'Vehicle loading record not found.',
            ], 404);
        }

        $details = $loading->details->map(function ($detail) {
            return [
                'idtbl_vehicle_loading_details' => $detail->idtbl_vehicle_loading_details,
                'tbl_vehicle_loading_idtbl_vehicle_loading' => $detail->tbl_vehicle_loading_idtbl_vehicle_loading,
                'tbl_product_idtbl_product' => $detail->tbl_product_idtbl_product,
                'productname' => $detail->product?->common_name,
                'qty' => $detail->qty,
                'qty_remaining' => (int) ($detail->qty_remaining ?? 0),
                'batches' => $detail->batches->map(fn ($batch) => [
                    'idtbl_vehicle_loading_details_batches' => $batch->idtbl_vehicle_loading_details_batches,
                    'tbl_batch_idtbl_batch' => $batch->tbl_batch_idtbl_batch,
                    'batchno' => $batch->batchStock?->batchno,
                    'qty_from_batch' => $batch->qty_from_batch,
                    'qty_returned' => (int) ($batch->qty_returned ?? 0),
                ])->values(),
            ];
        })->values();

        return response()->json([
            'status' => 'ok',
            'vehicle_loading_id' => $id,
            'details' => $details,
        ]);
    }
}
