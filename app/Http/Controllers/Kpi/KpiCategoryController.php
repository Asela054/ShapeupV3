<?php

namespace App\Http\Controllers\Kpi;

use App\Http\Controllers\Controller;
use App\Models\Kpi\KpiCategory;
use App\Services\Kpi\KpiCategoryService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class KpiCategoryController extends Controller
{
    protected $service;

    public function __construct(KpiCategoryService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $categories = KpiCategory::all();
        return view('kpi.categories', compact('categories'));
    }

    public function data(Request $request)
    {
        $query = KpiCategory::with(['parent'])->withCount('attributes');

        return DataTables::of($query)
            ->addColumn('parent_name', function ($row) {
                return $row->parent ? $row->parent->name : null;
            })
            ->make(true);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'parent_id'   => ['nullable', 'integer', 'exists:kpi_categories,id'],
            'description' => ['nullable', 'string'],
        ]);

        $category = $this->service->create($validated);

        return response()->json([
            'message' => 'KPI Category created successfully.',
            'data'    => $category,
        ]);
    }

    public function edit(KpiCategory $kpiCategory)
    {
        return response()->json($kpiCategory);
    }

    public function update(Request $request, KpiCategory $kpiCategory)
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'parent_id'   => ['nullable', 'integer', 'exists:kpi_categories,id', "different:{$kpiCategory->id}"],
            'description' => ['nullable', 'string'],
        ]);

        $category = $this->service->update($kpiCategory, $validated);

        return response()->json([
            'message' => 'KPI Category updated successfully.',
            'data'    => $category,
        ]);
    }

    public function destroy(KpiCategory $kpiCategory)
    {
        $this->service->delete($kpiCategory);

        return response()->json([
            'message' => 'KPI Category deleted successfully.',
        ]);
    }
}
