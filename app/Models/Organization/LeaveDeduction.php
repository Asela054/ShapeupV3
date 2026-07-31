<?php

namespace App\Models\Organization;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveDeduction extends Model
{
    use HasFactory;

    protected $table = 'leave_deductions';

    protected $fillable = [
        'job_id',
        'remuneration_id',
        'day_count',
        'amount',
    ];

    public function jobCategory()
    {
        return $this->belongsTo(JobCategory::class, 'job_id');
    }

    public function remuneration()
    {
        return $this->belongsTo(Remuneration::class, 'remuneration_id');
    }
}