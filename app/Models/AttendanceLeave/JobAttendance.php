<?php

namespace App\Models\AttendanceLeave;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobAttendance extends Model
{
    use HasFactory;

    protected $table = 'job_attendance';

    protected $fillable = [
        'attendance_date',
        'employee_id',
        'shift_id',
        'on_time',
        'off_time',
        'reason',
        'location_id',
        'allocation_id',
        'status',
        'location_status',
        'approve_status',
        'created_by',
        'updated_by',
    ];
}