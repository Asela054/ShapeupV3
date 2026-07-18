<?php

namespace App\Models\AttendanceLeave;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocationVisitAllowance extends Model
{
    use HasFactory;

    protected $table = 'location_visit_allowances';

    protected $fillable = [
        'employee_id',
        'from_date',
        'to_date',
        'visit_count',
        'amount',
        'status',
        'created_by',
        'updated_by',
    ];
}