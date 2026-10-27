<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\AttendanceLeave\LeaveType;
use Illuminate\Database\Seeder;

class LeaveTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $leaveTypes = [
            [
                'emp_status'     => '1',
                'leave_type'     => 'Annual Leave',
                'assigned_leave' => '0',
                'status'         => 1,
                'created_by'     => 1,
                'updated_by'     => 1,
            ],
            [
                'emp_status'     => '1',
                'leave_type'     => 'Casual Leave',
                'assigned_leave' => '0',
                'status'         => 1,
                'created_by'     => 1,
                'updated_by'     => 1,
            ],
            [
                'emp_status'     => '1',
                'leave_type'     => 'No Pay Leave',
                'assigned_leave' => '0',
                'status'         => 1,
                'created_by'     => 1,
                'updated_by'     => 1,
            ],
            [
                'emp_status'     => '2',
                'leave_type'     => 'Medical',
                'assigned_leave' => '0',
                'status'         => 1,
                'created_by'     => 1,
                'updated_by'     => 1,
            ],
            [
                'emp_status'     => '2',
                'leave_type'     => 'duty Leave',
                'assigned_leave' => '0',
                'status'         => 1,
                'created_by'     => 1,
                'updated_by'     => 1,
            ],
            [
                'emp_status'     => '3',
                'leave_type'     => 'Late Leave',
                'assigned_leave' => '0',
                'status'         => 1,
                'created_by'     => 1,
                'updated_by'     => 1,
            ],
        ];

        foreach ($leaveTypes as $leaveType) {
            LeaveType::updateOrCreate(
                [
                    'emp_status' => $leaveType['emp_status'],
                    'leave_type' => $leaveType['leave_type'],
                ],
                $leaveType
            );
        }
    }
}