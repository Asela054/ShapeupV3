<?php

namespace App\Models\EmpDetail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EmpDetail\Employee;

class EmployeeDependentDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'emp_id',
        'emp_dep_name',
        'emp_dep_relation',
        'emp_dep_type',
        'emp_dep_birthday',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'emp_id', 'id');
    }
}
