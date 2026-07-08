<?php

namespace App\Models\AttendanceLeave;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    use HasFactory;

    protected $table = 'holidays';

    protected $fillable = [
        'holiday_name',
        'holiday_type',
        'half_short',
        'start_time',
        'end_time',
        'date',
        'work_level',
        'status',
        'created_by',
        'updated_by',
    ];
}