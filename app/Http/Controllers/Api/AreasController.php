<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Area;
use Illuminate\Http\Request;

class AreasController extends Controller
{
    public function index()
    {
        $areas = Area::where('status', 1)
            ->get()
            ->map(function ($area) {
                return [
                    'id' => $area->idtbl_area,
                    'area' => $area->area
                ];
            });
        return response()->json($areas);
    }
}
