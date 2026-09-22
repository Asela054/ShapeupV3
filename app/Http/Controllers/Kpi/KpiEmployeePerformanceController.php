<?php

namespace App\Http\Controllers\Kpi;

use App\Http\Controllers\Controller;
use App\Models\EmpDetail\Employee;
use App\Models\Kpi\KpiYear;
use App\Models\Kpi\KpiAttribute;
use App\Services\Kpi\KpiEmployeePerformanceService;
use Illuminate\Http\Request;

class KpiEmployeePerformanceController extends Controller
{
    protected $service;

    public function __construct(KpiEmployeePerformanceService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $employees = Employee::select('id', 'emp_id', 'calling_name', 'emp_name_with_initial')
            ->where('deleted', 0)
            ->get();

        $evaluationYears = KpiYear::select('id', 'year_name', 'status')->get();
        $attributes = KpiAttribute::select('id', 'description')->get();

        return view('kpi.employee_performance', compact('employees', 'evaluationYears', 'attributes'));
    }

    public function data(Request $request)
    {
        $validated = $request->validate([
            'employee_id'        => ['required', 'integer'],
            'evaluation_year_id' => ['required', 'integer'],
            'period'             => ['required', 'in:mid_year,annual'],
        ]);

        $data = $this->service->getPerformanceData(
            (int)$validated['employee_id'],
            (int)$validated['evaluation_year_id'],
            $validated['period']
        );

        return response()->json($data);
    }

    public function storeSelf(Request $request)
    {
        $validated = $request->validate([
            'employee_id'        => ['required'],
            'evaluation_year_id' => ['required', 'integer', 'exists:kpi_years,id'],
            'period'             => ['required', 'in:mid_year,annual'],
            'kpi_attribute_id'   => ['required'],
            'self_score'         => ['required', 'numeric', 'min:1', 'max:10'],
        ]);

        $performance = $this->service->storeSelfScore($validated);

        return response()->json([
            'message' => 'Metric self-evaluation added successfully.',
            'data'    => $performance,
        ]);
    }

    public function storeSupervisor(Request $request)
    {
        $validated = $request->validate([
            'employee_kpi_metric_id' => ['required', 'integer', 'exists:employee_kpi_performances,id'],
            'supervisor_score'        => ['required', 'numeric', 'min:1', 'max:10'],
            'remark'                  => ['nullable', 'string'],
        ]);

        $performance = $this->service->storeSupervisorScore(
            (int)$validated['employee_kpi_metric_id'],
            $validated
        );

        return response()->json([
            'message' => 'Supervisor evaluation saved successfully.',
            'data'    => $performance,
        ]);
    }
}
