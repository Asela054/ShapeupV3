<?php

namespace App\Models\Kpi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EmpDetail\Employee;

class KpiSummary extends Model
{
    use HasFactory;

    protected $table = 'kpi_summaries';

    protected $fillable = [
        'employee_id',
        'year_id',
        'base_points',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'emp_id');
    }
}
