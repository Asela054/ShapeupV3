<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Province;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{
    // GET api/all-provinces
    public function index()
    {
        $provinces = Province::all()->map(function ($p) {
            return [
                'id' => $p->idtbl_province,
                'province_name' => $p->province_name,
            ];
        });

        return response()->json($provinces);
    }
}
