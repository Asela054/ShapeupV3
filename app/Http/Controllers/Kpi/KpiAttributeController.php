<?php

namespace App\Http\Controllers\Kpi;

use App\Http\Controllers\Controller;
use App\Models\Kpi\KpiAttribute;
use App\Models\Kpi\KpiCategory;
use App\Services\Kpi\KpiAttributeService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class KpiAttributeController extends Controller
{
    protected $service;

    public function __construct(KpiAttributeService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $categories = KpiCategory::all();
        return view('kpi.attributes', compact('categories'));
    }

    public function data(Request $request)
    {
        $query = KpiAttribute::with('category');

        return DataTables::of($query)
            ->addColumn('category_name', function ($row) {
                return $row->category ? $row->category->name : 'General Attribute';
            })
            ->make(true);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'description'     => ['required', 'string', 'max:255'],
            'kpi_category_id' => ['nullable', 'integer'],
            'category'        => ['required', 'in:functional,behavioral,non_points'],
            'fixed_points'    => ['required', 'numeric'],
        ]);

        $attribute = $this->service->create($validated);

        return response()->json(['message' => 'KPI attribute created successfully.', 'data' => $attribute]);
    }

    public function edit(KpiAttribute $kpiAttribute)
    {
        return response()->json($kpiAttribute);
    }

    public function update(Request $request, KpiAttribute $kpiAttribute)
    {
        $validated = $request->validate([
            'description'     => ['required', 'string', 'max:255'],
            'kpi_category_id' => ['nullable', 'integer'],
            'category'        => ['required', 'in:functional,behavioral,non_points'],
            'fixed_points'    => ['required', 'numeric'],
        ]);

        $attribute = $this->service->update($kpiAttribute, $validated);

        return response()->json(['message' => 'KPI attribute updated successfully.', 'data' => $attribute]);
    }

    public function destroy(KpiAttribute $kpiAttribute)
    {
        $this->service->delete($kpiAttribute);

        return response()->json(['message' => 'KPI attribute deleted successfully.']);
    }
}
