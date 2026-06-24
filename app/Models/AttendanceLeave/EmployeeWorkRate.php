<?php

namespace App\Models\AttendanceLeave;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeWorkRate extends Model
{
    use HasFactory;

    protected $table = 'employee_work_rates';

    protected $fillable = [
        'emp_id',
        'emp_etfno',
        'work_year',
        'work_month',
        'work_days',
        'working_week_days',
        'work_hours',
        'leave_days',
        'nopay_days',
        // 'emp_late_hours',
        'normal_rate_otwork_hrs',
        'double_rate_otwork_hrs',
        // 'triple_rate_otwork_hrs',
        // 'holiday_nopay_days',
        // 'holiday_normal_ot_hrs',
        // 'holiday_double_ot_hrs',
        'created_by',
        'updated_by',
    ];
}