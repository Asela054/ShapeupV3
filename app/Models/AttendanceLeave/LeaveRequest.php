<?php

namespace App\Models\AttendanceLeave;

use App\Models\EmpDetail\Employee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    use HasFactory;

    protected $table = 'leave_request';

    protected $fillable = [
        'emp_id',
        'from_date',
        'to_date',
        'leave_category',
        'reason',
        'leave_type',
        'from_time',
        'to_time',
        'status',
        'created_by',
        'updated_by',
        'approve_status',
        'request_approve_status',
        'covering_emp_id',
    ];

    /**
     * leave_request.emp_id → employees.emp_id
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'emp_id', 'emp_id');
    }
}