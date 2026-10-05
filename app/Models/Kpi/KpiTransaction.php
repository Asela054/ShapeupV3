<?php

namespace App\Models\Kpi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EmpDetail\Employee;

class KpiTransaction extends Model
{
    use HasFactory;

    protected $table = 'kpi_transactions';

    protected $fillable = [
        'employee_id',
        'attribute_id',
        'year_id',
        'quantity',
        'points_snapshot',
        'total_adjustment',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'emp_id');
    }
}
