<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Productcategory;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    public function index(){
        $sql = Productcategory::where('status', 1)->get()->map(function ($category){
            return [
                'id' => (string) $category->idtbl_product_category,
                'category' => (string) $category->name
            ];
        });
        return response()->json($sql);
    }
}
