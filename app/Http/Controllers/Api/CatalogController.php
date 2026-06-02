<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Catalog;
use App\Models\Productcategory;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(){
        // $catalog = Catalog::with('catalogCategory')
        //     ->where('status', 1)
        //     ->get()
        //     ->map(function($item){
        //         return [
        //             'id' => (string) $item-> idtbl_catalog,
        //             'category' => $item->catalogCategory->category
        //         ];
        //     });

        $catalog = Productcategory::where('status', 1)
            ->get()
            ->map(function($item){
                return [
                    'id' => (string) $item->idtbl_product_category,
                    'category' => $item->category
                ];
            });
        
        return response()->json($catalog);
    }
}
