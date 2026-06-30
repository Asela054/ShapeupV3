<?php

namespace App\Models\AttendanceLeave;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveDetail extends Model
{
    use HasFactory;

    protected $table = 'leave_details';

    protected $fillable = [
        'emp_id',
        'leave_type',
        'total_leave',
        'status',
        'created_by',
        'updated_by',
    ];
}