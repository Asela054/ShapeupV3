<?php

namespace App\Services\EmpMaster;

use App\Models\EmpMaster\EmploymentStatus;
use Illuminate\Support\Facades\DB;

class EmploymentStatusService
{
    public function create(array $data): EmploymentStatus
    {
        return DB::transaction(function () use ($data) {
            return EmploymentStatus::create($data);
        });
    }

    public function update(EmploymentStatus $employmentStatus, array $data): EmploymentStatus
    {
        return DB::transaction(function () use ($employmentStatus, $data) {
            $employmentStatus->update($data);

            return $employmentStatus;
        });
    }

    public function delete(EmploymentStatus $employmentStatus): void
    {
        DB::transaction(function () use ($employmentStatus) {
            $employmentStatus->delete();
        });
    }
}
