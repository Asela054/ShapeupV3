<?php

namespace App\Models\AttendanceLeave;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoverupDetail extends Model
{
    use HasFactory;

    protected $table = 'coverup_details';

    protected $fillable = [
        'emp_id',
        'date',
        'start_time',
        'end_time',
        'covering_hours',
        'status',
        'created_by',
        'updated_by'
    ];
}