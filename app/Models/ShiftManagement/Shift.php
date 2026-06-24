<?php

namespace App\Models\ShiftManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use HasFactory;

    protected $table = 'shifts';

    protected $fillable = [
        'emp_id',
        'shift_id',
        'shift_location',
        'start_time',
        'end_time',
        'status',
        'created_by',
        'updated_by',
    ];
}