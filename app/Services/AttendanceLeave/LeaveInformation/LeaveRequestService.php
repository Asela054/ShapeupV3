<?php

namespace App\Services\AttendanceLeave\LeaveInformation;

use App\Models\AttendanceLeave\LeaveRequest;
use Illuminate\Support\Facades\DB;

class LeaveRequestService
{
    public function create(array $data): LeaveRequest
    {
        return DB::transaction(function () use ($data) {
            $data['status']                 = 1;
            $data['approve_status']         = 0;
            $data['request_approve_status'] = 0;
            $data['created_by']             = auth()->id() ?? 1;
            $data['updated_by']             = 0;

            return LeaveRequest::create($data);
        });
    }

    public function update(LeaveRequest $leaveRequest, array $data): LeaveRequest
    {
        return DB::transaction(function () use ($leaveRequest, $data) {
            $data['request_approve_status'] = 0;
            $data['updated_by']             = auth()->id() ?? 1;

            $leaveRequest->update($data);

            return $leaveRequest;
        });
    }

    public function delete(LeaveRequest $leaveRequest): void
    {
        DB::transaction(function () use ($leaveRequest) {
            $leaveRequest->update([
                'status'                 => 2,
                'request_approve_status' => 2,
                'updated_by'             => auth()->id() ?? 1,
            ]);
        });
    }

    public function approve(LeaveRequest $leaveRequest): LeaveRequest
    {
        return DB::transaction(function () use ($leaveRequest) {
            $leaveRequest->update([
                'request_approve_status' => 1,
                'updated_by'             => auth()->id() ?? 1,
            ]);

            return $leaveRequest;
        });
    }

    public function getLeaveBalance(string $empId): array
    {
        $leaveTypes = ['Annual', 'Casual', 'Medical', 'Weekly'];
        $balance    = [];

        foreach ($leaveTypes as $type) {
            $key = strtolower($type);

            $total = DB::table('employee_leave_details')
                ->join('employees', 'employees.id', '=', 'employee_leave_details.emp_id')
                ->join('leave_types', 'leave_types.id', '=', 'employee_leave_details.leave_type_id')
                ->where('employees.emp_id', $empId)
                ->where('leave_types.leave_type', $type)
                ->value('employee_leave_details.allowed_days') ?? 0;

            $taken = DB::table('leaves')
                ->join('employees', 'employees.emp_id', '=', 'leaves.emp_id')
                ->where('employees.emp_id', $empId)
                ->where('leaves.leave_type', $type)
                ->where('leaves.status', 'Approved')
                ->sum('leaves.no_of_days') ?? 0;

            $available = max(0, $total - $taken);

            $balance[$key] = [
                'total'     => $total ?: '-',
                'taken'     => $taken ?: '-',
                'available' => $available ?: '-',
            ];
        }

        return $balance;
    }
}

