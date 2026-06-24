<?php

namespace App\Models\ShiftManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShiftType extends Model
{
    use HasFactory;

    protected $table = 'shift_types';

    protected $fillable = [
        'shift_code',
        'shift_name',
        'onduty_time',
        'offduty_time',
        'saturday_onduty_time',
        'saturday_offduty_time',
        'late_time',
        'leave_early_time',
        'begining_checkin',
        'begining_checkout',
        'ending_checkin',
        'ending_checkout',
        'workdays_count',
        'minute_count',
        'must_checkin',
        'must_checkout',
        'color',
        'offduty_day',
        'ot_calculate_type',
        'ot_calculate_time',
        'off_next_day',
        'on_next_day',
        'max_normal_ot_hrs',
        'max_double_ot_hrs',
        'weekend_max_normal_ot_hrs',
        'weekend_max_double_ot_hrs',
        'deleted',
        'status',
        'created_by',
        'updated_by',
    ];
}