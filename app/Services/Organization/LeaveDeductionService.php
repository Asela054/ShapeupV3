<?php

namespace App\Services\Organization;

use App\Models\Organization\LeaveDeduction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class LeaveDeductionService
{
    public function create(array $data): LeaveDeduction
    {
        return DB::transaction(function () use ($data) {
            return LeaveDeduction::create($data);
        });
    }

    public function update(LeaveDeduction $leaveDeduction, array $data): LeaveDeduction
    {
        return DB::transaction(function () use ($leaveDeduction, $data) {
            $leaveDeduction->update($data);

            return $leaveDeduction;
        });
    }

    public function delete(LeaveDeduction $leaveDeduction): void
    {
        DB::transaction(function () use ($leaveDeduction) {
            $leaveDeduction->delete();
        });
    }
}