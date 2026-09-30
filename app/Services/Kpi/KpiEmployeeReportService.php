<?php

namespace App\Services\Kpi;

use App\Models\EmpDetail\Employee;
use App\Models\EmpDetail\EmployeeEmploymentDetail;
use App\Models\Organization\Department;
use App\Models\Kpi\KpiSummary;
use App\Models\Kpi\KpiTransaction;
use Illuminate\Support\Facades\DB;

class KpiEmployeeReportService
{
    public function getEmployeeReportData(array $filters = []): array
    {
        $departmentId   = !empty($filters['department_id']) ? (int)$filters['department_id'] : null;
        $evaluationYear = !empty($filters['evaluation_year']) ? (int)$filters['evaluation_year'] : null;

        $employeesQuery = Employee::where('deleted', 0);

        if ($departmentId) {
            $empIdsInDept = EmployeeEmploymentDetail::where('emp_department', $departmentId)
                ->pluck('emp_id')
                ->toArray();
            $employeesQuery->whereIn('emp_id', $empIdsInDept);
        }

        $employees = $employeesQuery->select('id', 'emp_id', 'calling_name', 'emp_name_with_initial')->get();
        $empIds = $employees->pluck('emp_id')->toArray();

        $departmentsMap = Department::pluck('name', 'id')->toArray();
        $employmentDetailsMap = EmployeeEmploymentDetail::whereIn('emp_id', $empIds)
            ->pluck('emp_department', 'emp_id')
            ->toArray();

        $summaryQuery = KpiSummary::whereIn('employee_id', $empIds);
        if ($evaluationYear) {
            $summaryQuery->where('year_id', $evaluationYear);
        }
        $basePointsMap = $summaryQuery->pluck('base_points', 'employee_id')->toArray();

        $txQuery = KpiTransaction::whereIn('employee_id', $empIds)
            ->select('employee_id', DB::raw('SUM(total_adjustment) as total_adj'));
        if ($evaluationYear) {
            $txQuery->where('year_id', $evaluationYear);
        }
        $adjustmentsMap = $txQuery->groupBy('employee_id')
            ->pluck('total_adj', 'employee_id')
            ->toArray();

        $reportData = [];

        foreach ($employees as $emp) {
            $empId = $emp->emp_id;
            $deptId = $employmentDetailsMap[$empId] ?? null;
            $deptName = $deptId && isset($departmentsMap[$deptId]) ? $departmentsMap[$deptId] : 'Unassigned';

            $basePoints = isset($basePointsMap[$empId]) ? (float)$basePointsMap[$empId] : null;
            $adjustment = isset($adjustmentsMap[$empId]) ? (float)$adjustmentsMap[$empId] : 0.0;

            if ($basePoints !== null) {
                $currentScore = $basePoints + $adjustment;
                if ($currentScore >= 1000) {
                    $status = 'Outstanding';
                } elseif ($currentScore >= 800) {
                    $status = 'Satisfactory';
                } elseif ($currentScore >= 600) {
                    $status = 'Needs Improvement';
                } else {
                    $status = 'Below Expectation';
                }
            } else {
                $currentScore = null;
                $status = 'Pending';
            }

            $name = $emp->calling_name ?: $emp->emp_name_with_initial;

            $reportData[] = [
                'id'              => $emp->id,
                'employee_code'   => $empId,
                'name'            => $name,
                'department_name' => $deptName,
                'base_points'     => $basePoints,
                'current_score'   => $currentScore,
                'status'          => $status,
            ];
        }

        return $reportData;
    }
}
