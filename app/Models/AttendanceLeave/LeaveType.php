<?php

namespace App\Models\AttendanceLeave;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveType extends Model
{
    use HasFactory;

    protected $table = 'leave_types';

    protected $fillable = [
        'emp_status',
        'leave_type',
        'assigned_leave',
        'status',
        'created_by',
        'updated_by',
    ];
}
