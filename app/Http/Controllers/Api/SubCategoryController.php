<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function index(){
        $sql = DB::table('tbl_sub_product_category')
        ->where('status', 1)
        ->get()
        ->map(function($item){
            return [
                'id' => (string) $item->idtbl_sub_product_category,
                'category' => $item->category
            ];
        });

        return response()->json($sql);
    }
}
