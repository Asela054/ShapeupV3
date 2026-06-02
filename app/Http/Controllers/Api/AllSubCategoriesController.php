<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class AllSubCategoriesController extends Controller
{
    public function index(){
        $subcats = Subcategory::where('status', 1)
            ->get()
            ->map(function($subcat) {
                return [
                    'id' => (string) $subcat->idtbl_sub_product_category,
                    'category' => $subcat->category
                ];
            });
        return response()->json($subcats);
    }
}
