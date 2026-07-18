<?php

namespace App\Models\ShiftManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeShift extends Model
{
    use HasFactory;

    protected $table = 'employee_shifts';

    protected $fillable = [
        'shift_id',
        'date_from',
        'date_to',
        'remark',
        'status',
        'approval_status',
        'created_by',
        'updated_by',
    ];
}