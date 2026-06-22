<?php

namespace App\Models\Organization;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HolidayDeduction extends Model
{
    use HasFactory;

    protected $table = 'holiday_deductions';

    protected $fillable = [
        'job_id',
        'remuneration_id',
        'day_count',
        'amount',
    ];
}