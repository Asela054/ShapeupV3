<?php

namespace App\Models\AttendanceLeave;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtApproved extends Model
{
    use HasFactory;

    protected $table = 'ot_approved';

    protected $fillable = [
        'emp_id',
        'date',
        'from',
        'to',
        'hours',
        //'one_point_five_hours',
        'double_hours',
        // 'triple_hours',
        // 'holiday_normal_hours',
        // 'holiday_double_hours',
        'is_holiday',
        'status',
        'created_by',
    ];

    public function get_ot_hours_monthly($emp_id, $month, $closedate)
    {
        return OtApproved::where('emp_id', $emp_id)
            ->where('date', 'like', $month . '%')
            ->where('date', '<=', $closedate)
            ->where('status', '!=', 3)
            ->sum('hours');
    }

    public function get_double_ot_hours_monthly($emp_id, $month, $closedate)
    {
        return OtApproved::where('emp_id', $emp_id)
            ->where('date', 'like', $month . '%')
            ->where('date', '<=', $closedate)
            ->where('status', '!=', 3)
            ->sum('double_hours');
    }

    public function get_triple_ot_hours_monthly($emp_id, $month, $closedate)
    {
        return OtApproved::where('emp_id', $emp_id)
            ->where('date', 'like', $month . '%')
            ->where('date', '<=', $closedate)
            ->where('status', '!=', 3)
            ->sum('triple_hours');
    }

    public function is_exists_in_ot_approved($emp_id, $date, $OTfrom)
    {
        $date = Carbon::parse($date)->format('Y-m-d');

        $ot = OtApproved::where('emp_id', $emp_id)
            ->where('date', '=', $date)
            ->where('from', '=', $OTfrom)
            ->where(function ($query) {
                $query->where('status', '!=', 3)
                    ->orWhereNull('status');
            })
            ->get();

        return !$ot->isEmpty();
    }

    public function get_ot_hours_monthly_ktClean($emp_id, $month, $closedate)
    {
        return DB::table('kt_shift_ot')
            ->where('emp_id', $emp_id)
            ->where('date', 'like', $month . '%')
            ->where('date', '<=', $closedate)
            ->where('approve_status', '=', 1)
            ->sum('ot_hours');
    }

    public function get_night_work_days($emp_id, $month, $closedate)
    {
        return DB::table('employee_roster_details')
            ->where('employee_roster_details.emp_id', $emp_id)
            ->where('employee_roster_details.work_date', 'like', $month . '%')
            ->where('employee_roster_details.work_date', '<=', $closedate)
            ->whereIn('employee_roster_details.shift_id', [11, 12])
            ->join('attendances', function ($join) use ($emp_id) {
                $join->on(DB::raw('DATE(attendances.date)'), '=', 'employee_roster_details.work_date')
                    ->where('attendances.emp_id', '=', $emp_id);
            })
            ->distinct('employee_roster_details.work_date')
            ->count('employee_roster_details.work_date');
    }
}