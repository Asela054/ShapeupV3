<?php

namespace App\Models\AttendanceLeave;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeLateAttendanceMinite extends Model
{
    use HasFactory;

    protected $table = 'employee_late_attendance_minites';

    protected $fillable = [
        'attendance_id',
        'emp_id',
        'attendance_date',
        'minites_count',
        'status',
        'created_by',
        'updated_by',
    ];
}