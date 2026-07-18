<?php

namespace App\Models\AttendanceLeave;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobAllocation extends Model
{
    use HasFactory;

    protected $table = 'job_allocation';

    protected $fillable = [
        'location_id',
        'employee_id',
        'shiftid',
        'status',
        'created_by',
        'updated_by',
    ];
}