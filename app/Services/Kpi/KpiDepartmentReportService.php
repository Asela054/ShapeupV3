<?php

namespace App\Services\Kpi;

use App\Models\Organization\Department;
use App\Models\EmpDetail\EmployeeEmploymentDetail;
use App\Models\EmpDetail\Employee;
use App\Models\Kpi\KpiSummary;
use App\Models\Kpi\KpiTransaction;
use Illuminate\Support\Facades\DB;

class KpiDepartmentReportService
{
    public function getDepartmentKpiReportData(): array
    {
        $departments = Department::select('id', 'name')->get();

        $reportData = [];

        foreach ($departments as $dept) {
            $assignedEmpIds = EmployeeEmploymentDetail::where('emp_department', $dept->id)
                ->pluck('emp_id')
                ->toArray();

            $activeEmpIds = Employee::whereIn('emp_id', $assignedEmpIds)
                ->where('deleted', 0)
                ->pluck('emp_id')
                ->toArray();

            $employeesCount = count($activeEmpIds);

            if ($employeesCount > 0) {
                $basePointsMap = KpiSummary::whereIn('employee_id', $activeEmpIds)
                    ->pluck('base_points', 'employee_id')
                    ->toArray();

                $adjustmentsMap = KpiTransaction::whereIn('employee_id', $activeEmpIds)
                    ->select('employee_id', DB::raw('SUM(total_adjustment) as total_adj'))
                    ->groupBy('employee_id')
                    ->pluck('total_adj', 'employee_id')
                    ->toArray();

                $totalDepartmentScore = 0.0;
                $evaluatedEmployeesCount = 0;

                foreach ($activeEmpIds as $empId) {
                    $basePoints = isset($basePointsMap[$empId]) ? (float)$basePointsMap[$empId] : null;
                    $adjustment = isset($adjustmentsMap[$empId]) ? (float)$adjustmentsMap[$empId] : 0.0;

                    if ($basePoints !== null) {
                        $totalDepartmentScore += ($basePoints + $adjustment);
                        $evaluatedEmployeesCount++;
                    }
                }

                $avgScore = $evaluatedEmployeesCount > 0
                    ? round($totalDepartmentScore / $evaluatedEmployeesCount, 2)
                    : null;
            } else {
                $avgScore = null;
            }

            $reportData[] = [
                'id'              => $dept->id,
                'department_name' => $dept->name,
                'code'            => 'DEP-' . str_pad($dept->id, 3, '0', STR_PAD_LEFT),
                'employees_count' => $employeesCount,
                'avg_score'       => $avgScore,
            ];
        }

        return $reportData;
    }
}
