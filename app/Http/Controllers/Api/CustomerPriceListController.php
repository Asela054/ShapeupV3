<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CustomerPriceListController extends Controller
{
    public function index()
    {
        $data = DB::table('tbl_customer_product')
            ->where('status', 1)
            ->select(
                'idtbl_customer_product as id',
                'saleprice',
                'tbl_product_idtbl_product as productId',
                'tbl_customer_idtbl_customer as customerId'
            )
            ->get();

        return response()->json($data);
    }
}