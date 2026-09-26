<?php

namespace App\Models\Kpi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EmpDetail\Employee;

class EmployeeKpiPerformance extends Model
{
    use HasFactory;

    protected $table = 'employee_kpi_performances';

    protected $fillable = [
        'employee_id',
        'evaluation_year_id',
        'period',
        'kpi_attribute_id',
        'self_score',
        'supervisor_score',
        'remark',
        'created_by',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'emp_id');
    }

    public function evaluationYear()
    {
        return $this->belongsTo(KpiYear::class, 'evaluation_year_id');
    }

    public function attribute()
    {
        return $this->belongsTo(KpiAttribute::class, 'kpi_attribute_id');
    }
}
