<?php

namespace App\Services\AttendanceLeave\LeaveInformation;

use App\Models\AttendanceLeave\LeaveType;
use Illuminate\Support\Facades\DB;

class LeaveTypeService
{
    public function create(array $data): LeaveType
    {
        return DB::transaction(function () use ($data) {
            $data['created_by'] = auth()->id() ?? 1;
            $data['updated_by'] = auth()->id() ?? 1;
            $data['status'] = $data['status'] ?? 1;

            return LeaveType::create($data);
        });
    }

    public function update(LeaveType $leaveType, array $data): LeaveType
    {
        return DB::transaction(function () use ($leaveType, $data) {
            $data['updated_by'] = auth()->id() ?? 1;

            $leaveType->update($data);

            return $leaveType;
        });
    }

    public function delete(LeaveType $leaveType): void
    {
        DB::transaction(function () use ($leaveType) {
            $leaveType->delete();
        });
    }
}
