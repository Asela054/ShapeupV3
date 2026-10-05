<?php

namespace App\Services\Kpi;

use App\Models\Kpi\KpiYear;
use App\Models\Kpi\KpiSummary;
use App\Models\Kpi\KpiTransaction;
use App\Models\Kpi\KpiAttribute;
use App\Models\EmpDetail\Employee;
use App\Models\EmpDetail\EmployeeEmploymentDetail;
use App\Models\Organization\Department;
use Illuminate\Support\Facades\DB;

class KpiDashboardService
{
    public function getDashboardData(): array
    {
        // Active Evaluation Year
        $activeYearModel = KpiYear::where('status', 'active')->first() ?? KpiYear::latest('id')->first();
        $activeYearName  = $activeYearModel ? $activeYearModel->year_name : '2026-2027';
        $activeYearRange = $activeYearModel
            ? date('M d, Y', strtotime($activeYearModel->start_date)) . ' - ' . date('M d, Y', strtotime($activeYearModel->end_date))
            : 'Jan 01, 2026 - Dec 31, 2026';

        $stats = [
            'active_year'        => $activeYearName,
            'active_year_range'  => $activeYearRange,
            'kpi_summaries'      => KpiSummary::count(),
            'total_transactions' => KpiTransaction::count(),
            'kpi_attributes'     => KpiAttribute::count(),
        ];

        // Department Averages
        $deptReportService = new KpiDepartmentReportService();
        $deptData = $deptReportService->getDepartmentKpiReportData();

        $departmentAverages = [];
        foreach ($deptData as $d) {
            $departmentAverages[] = [
                'department_name' => $d['department_name'],
                'average_score'   => $d['avg_score'] !== null ? number_format($d['avg_score'], 2) : 'N/A',
            ];
        }

        // Scores per employee
        $summaries = KpiSummary::with('employee')->get();
        $empIds = $summaries->pluck('employee_id')->unique()->toArray();

        $adjustmentsMap = KpiTransaction::whereIn('employee_id', $empIds)
            ->select('employee_id', DB::raw('SUM(total_adjustment) as total_adj'))
            ->groupBy('employee_id')
            ->pluck('total_adj', 'employee_id')
            ->toArray();

        $departmentsMap = Department::pluck('name', 'id')->toArray();
        $employmentDetailsMap = EmployeeEmploymentDetail::whereIn('emp_id', $empIds)
            ->pluck('emp_department', 'emp_id')
            ->toArray();

        $employeeScores = [];

        foreach ($summaries as $s) {
            $emp = $s->employee;
            if (!$emp || $emp->deleted) {
                continue;
            }

            $empId = $s->employee_id;
            $basePoints = (float)$s->base_points;
            $adj = isset($adjustmentsMap[$empId]) ? (float)$adjustmentsMap[$empId] : 0.0;
            $totalScore = $basePoints + $adj;

            $deptId = $employmentDetailsMap[$empId] ?? null;
            $deptName = $deptId && isset($departmentsMap[$deptId]) ? $departmentsMap[$deptId] : 'Unassigned';

            $empName = $emp->calling_name ?: $emp->emp_name_with_initial;

            $employeeScores[] = [
                'employee_id'     => $empId,
                'employee_name'   => "[{$empId}] {$empName}",
                'department_name' => $deptName,
                'score'           => number_format($totalScore, 2),
                'raw_score'       => $totalScore,
            ];
        }

        // Sort descending by raw_score
        usort($employeeScores, function ($a, $b) {
            return $b['raw_score'] <=> $a['raw_score'];
        });

        // Top 5 overall
        $topOverall = array_slice($employeeScores, 0, 5);

        // Top 5 by Dept
        $groupedByDept = [];
        foreach ($employeeScores as $item) {
            $dName = $item['department_name'];
            if (!isset($groupedByDept[$dName])) {
                $groupedByDept[$dName] = [];
            }
            if (count($groupedByDept[$dName]) < 3) {
                $groupedByDept[$dName][] = $item;
            }
        }

        // Recent Transactions
        $transactions = KpiTransaction::with(['employee'])
            ->orderBy('id', 'desc')
            ->limit(5)
            ->get();

        $attributesMap = KpiAttribute::pluck('description', 'id')->toArray();

        $recentTransactions = [];
        foreach ($transactions as $tx) {
            $emp = $tx->employee;
            $empName = $emp ? ($emp->calling_name ?: $emp->emp_name_with_initial) : "ID: {$tx->employee_id}";
            $attrName = isset($attributesMap[$tx->attribute_id]) ? $attributesMap[$tx->attribute_id] : "Attribute #{$tx->attribute_id}";

            $recentTransactions[] = [
                'employee'   => "[{$tx->employee_id}] {$empName}",
                'attribute'  => $attrName,
                'quantity'   => $tx->quantity,
                'adjustment' => (float)$tx->total_adjustment,
                'date'       => $tx->created_at ? $tx->created_at->format('Y-m-d H:i') : '-',
            ];
        }

        return [
            'stats'                 => $stats,
            'department_averages'   => $departmentAverages,
            'top_employees_overall' => $topOverall,
            'top_employees_by_dept' => $groupedByDept,
            'recent_transactions'   => $recentTransactions,
        ];
    }
}
