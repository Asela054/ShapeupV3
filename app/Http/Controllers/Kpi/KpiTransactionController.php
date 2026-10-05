<?php

namespace App\Http\Controllers\Kpi;

use App\Http\Controllers\Controller;
use App\Models\EmpDetail\Employee;
use App\Models\Kpi\KpiTransaction;
use App\Services\Kpi\KpiTransactionService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class KpiTransactionController extends Controller
{
    protected $service;

    public function __construct(KpiTransactionService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $employees = Employee::select('id', 'emp_id', 'calling_name', 'emp_name_with_initial')
            ->where('deleted', 0)
            ->get()
            ->map(function ($emp) {
                $name = $emp->calling_name ?: $emp->emp_name_with_initial;
                return (object) [
                    'id'   => $emp->emp_id,
                    'name' => "[{$emp->emp_id}] {$name}",
                ];
            });

        $evaluationPeriods = [
            (object) ['id' => 1, 'year_name' => '2026-2027', 'status' => 'active'],
        ];

        $kpiAttributes = [
            (object) ['id' => 1, 'description' => 'Punctuality & Attendance', 'fixed_points' => 50.00],
            (object) ['id' => 2, 'description' => 'Quality of Deliverables', 'fixed_points' => 100.00],
            (object) ['id' => 3, 'description' => 'Team Collaboration', 'fixed_points' => 75.00],
        ];

        return view('kpi.transactions', compact('employees', 'evaluationPeriods', 'kpiAttributes'));
    }

    public function data(Request $request)
    {
        $query = KpiTransaction::with(['employee']);

        return DataTables::of($query)
            ->addColumn('employee_name', function ($row) {
                if ($row->employee) {
                    $name = $row->employee->calling_name ?: $row->employee->emp_name_with_initial;
                    return "[{$row->employee->emp_id}] {$name}";
                }
                return "Employee ID: {$row->employee_id}";
            })
            ->addColumn('attribute_description', function ($row) {
                $attributes = [
                    1 => 'Punctuality & Attendance',
                    2 => 'Quality of Deliverables',
                    3 => 'Team Collaboration',
                ];
                return $attributes[$row->attribute_id] ?? "Attribute #{$row->attribute_id}";
            })
            ->addColumn('year_name', function ($row) {
                return '2026-2027';
            })
            ->make(true);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id'     => ['required', 'integer'],
            'attribute_id'    => ['required', 'integer'],
            'year_id'         => ['required', 'integer'],
            'quantity'        => ['required', 'integer', 'min:1'],
            'points_snapshot' => ['nullable', 'numeric'],
        ]);

        if (!isset($validated['points_snapshot']) || floatval($validated['points_snapshot']) == 0) {
            $defaultPoints = [1 => 50.00, 2 => 100.00, 3 => 75.00];
            $validated['points_snapshot'] = $defaultPoints[$validated['attribute_id']] ?? 50.00;
        }

        $this->service->create($validated);

        return response()->json(['message' => 'KPI performance transaction recorded successfully.']);
    }

    public function edit(KpiTransaction $kpiTransaction)
    {
        $kpiTransaction->load('employee');
        return response()->json($kpiTransaction);
    }

    public function update(Request $request, KpiTransaction $kpiTransaction)
    {
        $validated = $request->validate([
            'employee_id'     => ['required', 'integer'],
            'attribute_id'    => ['required', 'integer'],
            'year_id'         => ['required', 'integer'],
            'quantity'        => ['required', 'integer', 'min:1'],
            'points_snapshot' => ['nullable', 'numeric'],
        ]);

        if (!isset($validated['points_snapshot']) || floatval($validated['points_snapshot']) == 0) {
            $defaultPoints = [1 => 50.00, 2 => 100.00, 3 => 75.00];
            $validated['points_snapshot'] = $defaultPoints[$validated['attribute_id']] ?? $kpiTransaction->points_snapshot;
        }

        $this->service->update($kpiTransaction, $validated);

        return response()->json(['message' => 'KPI performance transaction updated successfully.']);
    }

    public function destroy(KpiTransaction $kpiTransaction)
    {
        $this->service->delete($kpiTransaction);

        return response()->json(['message' => 'KPI performance transaction deleted successfully.']);
    }
}
