<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AreaController extends Controller
{
    /**
     * Return all active areas (legacy getallareas.php)
     * GET /api/getallareas
     */
    public function index()
    {
        $areas = DB::table('tbl_area')
            ->select('idtbl_area as id', 'area')
            ->where('status', 1)
            ->orderBy('area')
            ->get();

        return response()->json($areas);
    }
}
