<?php

namespace App\Http\Controllers\Kpi;

use App\Http\Controllers\Controller;
use App\Models\Kpi\KpiYear;
use App\Services\Kpi\KpiYearService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class KpiYearController extends Controller
{
    protected $service;

    public function __construct(KpiYearService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        return view('kpi.evaluation_year');
    }

    public function data(Request $request)
    {
        $query = KpiYear::query();

        return DataTables::of($query)->make(true);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'year_name'  => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date'   => ['required', 'date', 'after_or_equal:start_date'],
            'status'     => ['required', 'in:active,closed'],
        ]);

        $year = $this->service->create($validated);

        return response()->json([
            'message' => 'KPI evaluation year created successfully.',
            'data'    => $year,
        ]);
    }

    public function edit(KpiYear $kpiYear)
    {
        return response()->json($kpiYear);
    }

    public function update(Request $request, KpiYear $kpiYear)
    {
        $validated = $request->validate([
            'year_name'  => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date'   => ['required', 'date', 'after_or_equal:start_date'],
            'status'     => ['required', 'in:active,closed'],
        ]);

        $year = $this->service->update($kpiYear, $validated);

        return response()->json([
            'message' => 'KPI evaluation year updated successfully.',
            'data'    => $year,
        ]);
    }

    public function toggleStatus(Request $request, KpiYear $kpiYear)
    {
        $validated = $request->validate([
            'status' => ['nullable', 'in:active,closed'],
        ]);

        $year = $this->service->toggleStatus($kpiYear, $validated['status'] ?? null);

        return response()->json([
            'message' => 'KPI evaluation year status updated successfully.',
            'data'    => $year,
        ]);
    }

    public function destroy(KpiYear $kpiYear)
    {
        $this->service->delete($kpiYear);

        return response()->json([
            'message' => 'KPI evaluation year deleted successfully.',
        ]);
    }
}
