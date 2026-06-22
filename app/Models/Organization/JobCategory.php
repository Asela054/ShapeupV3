<?php

namespace App\Models\Organization;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobCategory extends Model
{
    use HasFactory;

    protected $table = 'job_categories';

    protected $fillable = [
        'category',
        'annual_leaves',
        'casual_leaves',
        'medical_leaves',
        'normal_ot_rate',
        'double_ot_rate',
        'no_pay_rate_per_hour',
        'no_pay_rate_per_day',
        'saturday_rate',
        'sunday_rate',
        'emp_payroll_workdays',
        'emp_payroll_workhrs',
        'is_sat_ot_type_as_act',
        'custom_saturday_ot_type',
        'is_sun_ot_type_as_act',
        'custom_sunday_ot_type',
        'sun_after_double',
        'spe_day_1_day',
        'spe_day_1_type',
        'spe_day_1_rate',
        'ot_app_hours',
        'holiday_ot_minimum_min',
        'holiday_ot_start',
        'holiday_lunch_deduct',
        'spe_deduct_pre',
        'lunch_deduct_type',
        'lunch_deduct_min',
        'morning_ot',
        'shift_hours',
        'work_hour_date',
        'late_attend_min',
        'salary_without_attendace',
        'holiday_work_hours',
        'late_type',
        'short_leaves',
        'half_days',
        'week_after_double',
        'ot_round_time',
        'flex_ot',
        'late_deduction_type',
        'basic_ot_type',
        'custom_normal_ot_rate',
        'custom_double_ot_rate',
        'salary_advance_type',
        'salary_advance_value',
        'salary_advance_min_date',
        'late_deduct_calculation',
        'full_day_work_hours',
    ];
}