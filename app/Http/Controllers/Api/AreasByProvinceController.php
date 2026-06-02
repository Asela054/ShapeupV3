<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Province;
use Illuminate\Http\Request;

class AreasByProvinceController extends Controller
{
    // GET api/areas-by-province?province_id=?
    public function index(Request $request)
    {
        $request->validate([
            'province_id' => 'required|integer|exists:tbl_province,idtbl_province',
        ]);

        $province = Province::with([
            'districts.areas' => function ($query) {
                $query->where('status', 1);
            }
        ])->findOrFail($request->province_id);

        $areas = collect();

        foreach ($province->districts as $district) {
            foreach ($district->areas as $area) {
                $areas->push([
                    'id'          => $area->idtbl_area,
                    'area'        => $area->area,
                ]);
            }
        }

        return response()->json($areas);
    }
}