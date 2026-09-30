<?php

namespace App\Services\Kpi;

use App\Models\EmpDetail\Employee;
use App\Models\EmpDetail\EmployeeEmploymentDetail;
use App\Models\Organization\Department;
use App\Models\Kpi\KpiAttribute;
use App\Models\Kpi\EmployeeKpiPerformance;
use Illuminate\Support\Facades\DB;

class KpiEmployeePerformanceService
{
    public function getPerformanceData(int $employeeId, int $yearId, string $period): array
    {
        $employee = Employee::where('emp_id', $employeeId)->first();

        if (!$employee) {
            return [
                'employee' => null,
                'metrics'  => [],
                'can_edit_supervisor_score' => true,
            ];
        }

        $employmentDetail = EmployeeEmploymentDetail::where('emp_id', $employeeId)->first();

        $deptName = 'Unassigned';
        if ($employmentDetail && $employmentDetail->emp_department) {
            $dept = Department::find($employmentDetail->emp_department);
            if ($dept) {
                $deptName = $dept->name;
            }
        }

        $position = $employmentDetail ? ($employmentDetail->emp_job_title ?? 'Employee') : 'Employee';

        $supervisorName = 'N/A';
        if ($employmentDetail && $employmentDetail->leave_approve_person) {
            $sup = Employee::where('emp_id', $employmentDetail->leave_approve_person)->first();
            if ($sup) {
                $supervisorName = $sup->calling_name ?: $sup->emp_name_with_initial;
            }
        }

        $periodLabel = ($period === 'annual') ? 'Annual Evaluation' : 'Mid-Year Evaluation';

        $records = EmployeeKpiPerformance::with('attribute')
            ->where('employee_id', $employeeId)
            ->where('evaluation_year_id', $yearId)
            ->where('period', $period)
            ->get();

        $metrics = $records->map(function ($rec) {
            return [
                'id'               => $rec->id,
                'attribute_name'   => $rec->attribute ? $rec->attribute->description : "Metric #{$rec->kpi_attribute_id}",
                'self_score'       => $rec->self_score !== null ? (float)$rec->self_score : null,
                'supervisor_score' => $rec->supervisor_score !== null ? (float)$rec->supervisor_score : null,
                'remark'           => $rec->remark,
            ];
        })->toArray();

        return [
            'employee' => [
                'name'            => $employee->calling_name ?: $employee->emp_name_with_initial,
                'position'        => $position,
                'department'      => $deptName,
                'supervisor_name' => $supervisorName,
                'period_label'    => $periodLabel,
            ],
            'metrics' => $metrics,
            'can_edit_supervisor_score' => true,
        ];
    }

    public function storeSelfScore(array $data): EmployeeKpiPerformance
    {
        return DB::transaction(function () use ($data) {
            $attributeId = $data['kpi_attribute_id'];

            // Handle custom attribute creation if string is passed
            if (!is_numeric($attributeId)) {
                $newAttr = KpiAttribute::create([
                    'description'     => $attributeId,
                    'category'        => 'functional',
                    'fixed_points'    => 10.0,
                ]);
                $attributeId = $newAttr->id;
            }

            return EmployeeKpiPerformance::updateOrCreate(
                [
                    'employee_id'        => $data['employee_id'],
                    'evaluation_year_id' => $data['evaluation_year_id'],
                    'period'             => $data['period'],
                    'kpi_attribute_id'   => $attributeId,
                ],
                [
                    'self_score' => $data['self_score'],
                ]
            );
        });
    }

    public function storeSupervisorScore(int $performanceId, array $data): EmployeeKpiPerformance
    {
        return DB::transaction(function () use ($performanceId, $data) {
            $metric = EmployeeKpiPerformance::findOrFail($performanceId);
            $metric->update([
                'supervisor_score' => $data['supervisor_score'],
                'remark'           => $data['remark'] ?? null,
            ]);
            return $metric;
        });
    }
}
