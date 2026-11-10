<?php

namespace App\Services\AttendanceLeave\LeaveInformation;

use App\Models\AttendanceLeave\Leave;
use App\Models\AttendanceLeave\LeaveDetail;
use App\Models\AttendanceLeave\LeaveRequest;
use Illuminate\Support\Facades\DB;

class LeaveApplyService
{
    public function create(array $data): Leave
    {
        return DB::transaction(function () use ($data) {
            $data['status'] = 'Pending';

            $leave = Leave::create($data);

            // Update leave_request approve status if linked
            if (!empty($data['request_id'])) {
                LeaveRequest::where('id', $data['request_id'])
                    ->update(['request_approve_status' => 1]);
            }

            // Update leave details balance
            $this->updateLeaveDetailBalance(
                $data['emp_id'],
                $data['leave_type'],
                $data['no_of_days'] ?? 0
            );

            return $leave;
        });
    }

    public function update(Leave $leave, array $data): Leave
    {
        return DB::transaction(function () use ($leave, $data) {
            $data['status'] = 'Pending';

            $leave->update($data);

            return $leave;
        });
    }

    public function delete(Leave $leave): void
    {
        DB::transaction(function () use ($leave) {
            $leave->delete();
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

    private function updateLeaveDetailBalance(string $empId, string $leaveType, float $noOfDays): void
    {
        $exists = DB::table('leave_details')
            ->where('emp_id', $empId)
            ->count();

        if ($exists == 0) {
            LeaveDetail::create([
                'emp_id'      => $empId,
                'leave_type'  => $leaveType,
                'total_leave' => max(0, -$noOfDays),
            ]);
        } else {
            DB::table('leave_details')
                ->where('emp_id', $empId)
                ->where('leave_type', $leaveType)
                ->decrement('total_leave', $noOfDays);
        }
    }
}
