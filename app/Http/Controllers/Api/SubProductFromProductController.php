<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubProductFromProductController extends Controller
{

public function index(Request $request)
{
    $productCategory = $request->producategory;
    $groupCategory = $request->groupcategory;

    $data = DB::table('tbl_sub_product_category as s')
        ->join('tbl_product as p', 's.idtbl_sub_product_category', '=', 'p.tbl_sub_product_category_idtbl_sub_product_category')
        ->where('s.status', 1)
        ->where('s.tbl_product_category_idtbl_product_category', $productCategory)
        ->where('p.tbl_group_category_idtbl_group_category', $groupCategory)
        ->distinct()
        ->select('s.idtbl_sub_product_category as id', 's.category')
        ->get()
        ->map(function ($item) {
            return [
                "id" => (string) $item->id,
                "category" => $item->category
            ];
        });

    return response()->json($data);
}
}
