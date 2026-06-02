<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Area;
use Illuminate\Http\Request;

class SalesRepsAreaController extends Controller
{
    public function index(Request $request){
        $sql = Area::with('repsArea.employee')
            ->whereHas('repsArea.employee', function ($q) use ($request){
                $q->where('tbl_employee_idtbl_employee', $request->refId);
            })
            ->get()
            ->map(function ($area){
                return [
                    'id' => (string) $area->idtbl_area,
                    'area' => $area->area,
                ];
            });
        return response()->json($sql);
    }
}
