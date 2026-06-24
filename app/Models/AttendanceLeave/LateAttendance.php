<?php

namespace App\Models\AttendanceLeave;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeLateAttendance extends Model
{
    use HasFactory;

    protected $table = 'employee_late_attendances';

    protected $fillable = [
        'attendance_id',
        'emp_id',
        'date',
        'check_in_time',
        'check_out_time',
        'working_hours',
        'status',
        'created_by',
        'updated_by',
        'is_approved',
        'approved_by',
        'approved_at',
    ];
}