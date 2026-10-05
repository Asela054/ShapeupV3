<?php

namespace App\Http\Controllers\Kpi;

use App\Http\Controllers\Controller;
use App\Models\EmpDetail\Employee;
use App\Models\Kpi\KpiSummary;
use App\Services\Kpi\KpiSummaryService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class KpiSummaryController extends Controller
{
    protected $service;

    public function __construct(KpiSummaryService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $employees = Employee::select('id', 'emp_id', 'calling_name', 'emp_name_with_initial')
            ->where('deleted', 0)
            ->get();

        return view('kpi.summaries', compact('employees'));
    }

    public function data(Request $request)
    {
        $query = KpiSummary::with(['employee']);

        return DataTables::of($query)
            ->addColumn('employee', function ($row) {
                if ($row->employee) {
                    $name = $row->employee->calling_name ?: $row->employee->emp_name_with_initial;
                    return "[{$row->employee->emp_id}] {$name}";
                }
                return "Employee ID: {$row->employee_id}";
            })
            ->addColumn('department', function ($row) {
                return '-';
            })
            ->addColumn('evaluation_year', function ($row) {
                return '2026-2027';
            })
            ->addColumn('current_score', function ($row) {
                return $row->base_points;
            })
            ->make(true);
    }

    public function store(Request $request)
    {
        if ($request->has('employee_ids') && is_array($request->employee_ids)) {
            $validated = $request->validate([
                'employee_ids'   => ['required', 'array', 'min:1'],
                'employee_ids.*' => ['required', 'integer'],
                'base_points'    => ['required', 'numeric', 'min:0'],
            ]);

            $this->service->bulkCreate(
                $validated['employee_ids'],
                1,
                (float) $validated['base_points']
            );

            return response()->json(['message' => 'Base KPI points allocated successfully.']);
        }

        $validated = $request->validate([
            'employee_id' => ['required', 'integer'],
            'base_points' => ['required', 'numeric', 'min:0'],
        ]);

        $this->service->create([
            'employee_id' => $validated['employee_id'],
            'year_id'     => 1,
            'base_points' => $validated['base_points'],
        ]);

        return response()->json(['message' => 'KPI summary created successfully.']);
    }

    public function edit(KpiSummary $kpiSummary)
    {
        $kpiSummary->load('employee');
        $data = $kpiSummary->toArray();
        $data['evaluation_year'] = '2026-2027';
        return response()->json($data);
    }

    public function update(Request $request, KpiSummary $kpiSummary)
    {
        $validated = $request->validate([
            'base_points' => ['required', 'numeric', 'min:0'],
        ]);

        if ($request->filled('employee_id')) {
            $validated['employee_id'] = $request->employee_id;
        }

        $this->service->update($kpiSummary, $validated);

        return response()->json(['message' => 'KPI summary updated successfully.']);
    }

    public function destroy(KpiSummary $kpiSummary)
    {
        $this->service->delete($kpiSummary);

        return response()->json(['message' => 'KPI summary deleted successfully.']);
    }
}
