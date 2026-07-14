<?php

namespace App\Models\EmpDetail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EmpDetail\Employee;

class EmployeeEducation extends Model
{
    use HasFactory;

    protected $fillable = [
        'emp_id',
        'emp_level',
        'emp_institute',
        'emp_specification',
        'emp_year',
        'emp_gpa',
        'emp_start_date',
        'emp_end_date',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'emp_id', 'id');
    }
}
