<?php

namespace App\Models\EmpDetail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeSalary extends Model
{
    use HasFactory;

    protected $table = 'employee_salaries';

    protected $fillable = [
        'emp_id',
        'emp_sal_basic_salary',
        'br_01',
        'br_02',
        'total',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'emp_id', 'id');
    }
}
