<?php

namespace App\Services\Organization;

use App\Models\Organization\SalaryAdjustment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SalaryAdjustmentService
{
    public function create(array $data): SalaryAdjustment
    {
        return DB::transaction(function () use ($data) {
            // emp_id / job_id are NOT NULL 
            $data['emp_id'] = $data['adjustment_type'] == 1 ? ($data['emp_id'] ?? 0) : 0;
            $data['job_id'] = $data['adjustment_type'] == 2 ? ($data['job_id'] ?? 0) : 0;

            $data['approved_status'] = 0;
            $data['status'] = 1;
            $data['created_by'] = auth()->id();
            $data['updated_by'] = auth()->id();

            return SalaryAdjustment::create($data);
        });
    }

    public function delete(SalaryAdjustment $salaryAdjustment): void
    {
        $salaryAdjustment->delete();
    }
}