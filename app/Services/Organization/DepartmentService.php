<?php

namespace App\Services\Organization;

use App\Models\Organization\Department;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DepartmentService
{
    public function create(array $data): Department
    {
        return DB::transaction(function () use ($data) {
            $data['created_by'] = auth()->id() ?? 1;
            $data['updated_by'] = auth()->id() ?? 1;

            return Department::create($data);
        });
    }

    public function update(Department $department, array $data): Department
    {
        return DB::transaction(function () use ($department, $data) {
            $data['updated_by'] = auth()->id() ?? 1;

            $department->update($data);

            return $department;
        });
    }

    public function delete(Department $department): void
    {
        DB::transaction(function () use ($department) {
            $department->delete();
        });
    }
}
