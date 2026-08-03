<?php

namespace App\Models\EmpDetail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EmpDetail\Employee;

class EmployeePersonalDetail extends Model
{
    use HasFactory;

    protected $table = 'employee_personal_details';
 
    protected $fillable = [
        'emp_id',
        'emp_first_name',
        'emp_med_name',
        'emp_last_name',
        'emp_fullname',
        'emp_nick_name',
        'emp_gender',
        'emp_marital_status',
        'emp_nationality',
        'emp_birthday',
        'emp_national_id',
        'emp_salary_grade',
    ];
 
    /**
     * employee_personal_details.emp_id → employees.id
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'emp_id', 'id');
    }
}
