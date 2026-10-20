<?php

namespace App\Services\Reports;

use App\Models\EmpDetail\EmployeeBank;
use Illuminate\Database\Eloquent\Builder;

class EmployeeBankReportService
{
    public function getEmployeeBankReportQuery(array $filters = []): Builder
    {
        $query = EmployeeBank::whereHas('employee', function ($q) {
                $q->where('deleted', 0);
            })
            ->with([
                'employee.employmentDetail.department',
                'employee.employmentDetail.location',
                'bank',
                'branch',
            ]);

        if (!empty($filters['company_id'])) {
            $query->whereHas('employee.employmentDetail', function ($q) use ($filters) {
                $q->where('emp_company', $filters['company_id']);
            });
        }

        if (!empty($filters['department_id'])) {
            $query->whereHas('employee.employmentDetail', function ($q) use ($filters) {
                $q->where('emp_department', $filters['department_id']);
            });
        }

        if (!empty($filters['bank_id'])) {
            $bankId = $filters['bank_id'];
            $query->where(function ($q) use ($bankId) {
                $q->where('bank_code', $bankId)
                  ->orWhereHas('bank', function ($bq) use ($bankId) {
                      $bq->where('id', $bankId)
                         ->orWhere('code', $bankId);
                  });
            });
        }

        return $query;
    }
}
