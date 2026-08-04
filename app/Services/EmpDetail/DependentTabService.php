<?php

namespace App\Services\EmpDetail;

use App\Models\EmpDetail\Employee;
use App\Models\EmpDetail\EmployeeDependentDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DependentTabService
{
    public function getDependentsQuery(Employee $employee)
    {
        return EmployeeDependentDetail::query()->where('emp_id', $employee->id);
    }

    public function store(Employee $employee, array $data): EmployeeDependentDetail
    {
        return DB::transaction(function () use ($employee, $data) {
            return EmployeeDependentDetail::create([
                'emp_id'           => $employee->id,
                'emp_dep_name'     => $data['emp_dep_name'] ?? ($data['name'] ?? null),
                'emp_dep_relation' => $data['emp_dep_relation'] ?? ($data['relation'] ?? null),
                'emp_dep_type'     => $data['emp_dep_type'] ?? null,
                'emp_dep_birthday' => $data['emp_dep_birthday'] ?? ($data['birthday'] ?? null),
            ]);
        });
    }

    public function find(int $id): ?EmployeeDependentDetail
    {
        return EmployeeDependentDetail::find($id);
    }

    public function update(EmployeeDependentDetail $dependent, array $data): EmployeeDependentDetail
    {
        return DB::transaction(function () use ($dependent, $data) {
            $dependent->update([
                'emp_dep_name'     => $data['emp_dep_name'] ?? ($data['name'] ?? $dependent->emp_dep_name),
                'emp_dep_relation' => $data['emp_dep_relation'] ?? ($data['relation'] ?? $dependent->emp_dep_relation),
                'emp_dep_type'     => $data['emp_dep_type'] ?? $dependent->emp_dep_type,
                'emp_dep_birthday' => array_key_exists('emp_dep_birthday', $data) ? $data['emp_dep_birthday'] : (array_key_exists('birthday', $data) ? $data['birthday'] : $dependent->emp_dep_birthday),
            ]);

            return $dependent->fresh();
        });
    }

    public function delete(EmployeeDependentDetail $dependent): ?bool
    {
        return DB::transaction(function () use ($dependent) {
            return $dependent->delete();
        });
    }
}
