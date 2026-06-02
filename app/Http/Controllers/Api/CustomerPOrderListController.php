<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\POrder;
use Illuminate\Http\Request;

class CustomerPOrderListController extends Controller
{
    public function index(Request $request)
    {
        $repId = (int) $request->input('repid', 0);

        if ($repId <= 0) {
            return response()->json([]);
        }

        $orders = POrder::query()
            ->where('status', 1)
            ->whereHas('otherInfo', fn ($q) => $q->where('repid', $repId))
            ->with([
                'otherInfo.customer:idtbl_customer,name,address',
                'otherInfo.area:idtbl_area,area',
                'details' => fn ($q) => $q
                    ->where('status', 1)
                    ->with('product:idtbl_product,product_name'),
            ])
            ->get();

        $data = $orders->map(function ($order) {
            $orderData = $order->toArray();
            $orderData['customername'] = $order->otherInfo?->customer?->name;
            $orderData['address'] = $order->otherInfo?->customer?->address;
            $orderData['area'] = $order->otherInfo?->area?->area;

            $detailData = $order->details->map(function ($detail) {
                $d = $detail->toArray();
                $d['product_name'] = $detail->product?->product_name;
                return $d;
            })->values();

            return [
                'data' => $orderData,
                'detaildata' => $detailData,
            ];
        })->values();

        return response()->json($data);
    }
}
