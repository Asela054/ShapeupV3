<?php

namespace App\Models\AttendanceLeave;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IgnoreDay extends Model
{
    use HasFactory;

    protected $table = 'ignore_days';

    protected $fillable = [
        'month',
        'date',
        'status',
        'created_by',
        'updated_by',
    ];
}