<?php

namespace App\Models\Organization;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryAdjustment extends Model
{
    use HasFactory;

    protected $table = 'salary_adjustments';

    protected $fillable = [
        'emp_id',
        'job_id',
        'remuneration_id',
        'adjustment_type',
        'allowance_type',
        'amount',
        'allowleave',
        'approved_status',
        'approved_by',
        'approved_at',
        'status',
        'created_by',
        'updated_by',
    ];
}