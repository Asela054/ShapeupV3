<?php

namespace App\Services\EmpDetail;

use App\Models\EmpDetail\Employee;
use App\Models\EmpDetail\EmployeeSalary;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SalaryTabService
{
    public function getSalaryQuery(Employee $employee)
    {
        return EmployeeSalary::query()->where('emp_id', $employee->id);
    }

    public function store(Employee $employee, array $data): EmployeeSalary
    {
        return DB::transaction(function () use ($employee, $data) {
            $basic = (float) ($data['emp_sal_basic_salary'] ?? ($data['basic_salary'] ?? 0));
            $br01  = (float) ($data['br_01'] ?? 0);
            $br02  = (float) ($data['br_02'] ?? 0);
            $total = isset($data['total']) && $data['total'] !== '' ? (float) $data['total'] : ($basic + $br01 + $br02);

            return EmployeeSalary::create([
                'emp_id'               => $employee->id,
                'emp_sal_basic_salary' => $basic,
                'br_01'                => $br01,
                'br_02'                => $br02,
                'total'                => $total,
            ]);
        });
    }

    public function find(int $id): ?EmployeeSalary
    {
        return EmployeeSalary::find($id);
    }

    public function update(EmployeeSalary $salary, array $data): EmployeeSalary
    {
        return DB::transaction(function () use ($salary, $data) {
            $basic = array_key_exists('emp_sal_basic_salary', $data) ? (float) $data['emp_sal_basic_salary'] : (array_key_exists('basic_salary', $data) ? (float) $data['basic_salary'] : $salary->emp_sal_basic_salary);
            $br01  = array_key_exists('br_01', $data) ? (float) $data['br_01'] : $salary->br_01;
            $br02  = array_key_exists('br_02', $data) ? (float) $data['br_02'] : $salary->br_02;
            $total = array_key_exists('total', $data) && $data['total'] !== '' ? (float) $data['total'] : ($basic + $br01 + $br02);

            $salary->update([
                'emp_sal_basic_salary' => $basic,
                'br_01'                => $br01,
                'br_02'                => $br02,
                'total'                => $total,
            ]);

            return $salary->fresh();
        });
    }

    public function delete(EmployeeSalary $salary): ?bool
    {
        return DB::transaction(function () use ($salary) {
            return $salary->delete();
        });
    }
}
