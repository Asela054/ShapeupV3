<?php

namespace App\Services\Reports;

use App\Models\EmpDetail\Employee;
use Illuminate\Database\Eloquent\Builder;

class EmployeeReportService
{
    public function getEmployeeReportQuery(array $filters = []): Builder
    {
        $query = Employee::where('employees.deleted', 0)
            ->with([
                'personalDetail',
                'contactDetail',
                'employmentDetail.department',
                'employmentDetail.location',
                'employmentDetail.jobCategory',
                'employmentStatus',
            ]);

        if (!empty($filters['company_id'])) {
            $query->whereHas('employmentDetail', function ($q) use ($filters) {
                $q->where('emp_company', $filters['company_id']);
            });
        }

        if (!empty($filters['department_id'])) {
            $query->whereHas('employmentDetail', function ($q) use ($filters) {
                $q->where('emp_department', $filters['department_id']);
            });
        }

        return $query;
    }
}
