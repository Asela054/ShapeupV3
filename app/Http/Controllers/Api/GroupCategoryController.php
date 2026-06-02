<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Productcategory;
use Illuminate\Http\Request;

class GroupCategoryController extends Controller
{
    public function index(){
        $sql = Productcategory::where('status', 1)
            ->get()
            ->map(function($cat) {
                return [
                    'id' => (string) $cat->idtbl_product_category,
                    'category' => $cat->category
                ];
            });
        return response()->json($sql);
    }
}
