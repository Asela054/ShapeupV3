<?php

namespace App\Models\EmpDetail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EmpDetail\Employee;

class EmployeeExperience extends Model
{
    use HasFactory;

    protected $fillable = [
        'emp_id',
        'emp_company',
        'emp_jobtitle',
        'emp_from_date',
        'emp_to_date',
        'emp_comment',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'emp_id', 'id');
    }
}