<?php

namespace App\Services\Reports;

use App\Models\EmpDetail\EmployeeResignationDetail;
use Illuminate\Database\Eloquent\Builder;

class EmployeeResignReportService
{
    public function getEmployeeResignReportQuery(array $filters = []): Builder
    {
        $query = EmployeeResignationDetail::whereHas('employee', function ($q) {
                $q->where('deleted', 0)
                  ->where('is_resigned', 1);
            })
            ->with([
                'employee.personalDetail',
                'employee.contactDetail',
                'employee.employmentDetail.department',
                'employee.employmentDetail.location',
                'employee.employmentDetail.jobCategory',
                'employee.employmentDetail.company',
            ]);

        if (!empty($filters['department_id'])) {
            $query->whereHas('employee.employmentDetail', function ($q) use ($filters) {
                $q->where('emp_department', $filters['department_id']);
            });
        }

        if (!empty($filters['from_date'])) {
            $query->where('resignation_date', '>=', $filters['from_date']);
        }

        if (!empty($filters['to_date'])) {
            $query->where('resignation_date', '<=', $filters['to_date']);
        }

        return $query;
    }
}
