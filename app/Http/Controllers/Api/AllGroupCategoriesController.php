<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Groupcategory;
use Illuminate\Http\Request;

class AllGroupCategoriesController extends Controller
{
    public function index()
    {
        $categories = Groupcategory::where('status', 1)
            ->get(['idtbl_group_category', 'category']);

        $result = $categories->map(function ($category) {
            return [
                'id' => (string) $category->idtbl_group_category,
                'category' => $category->category
            ];
        })->values();

        return response()->json($result);
    }
}
