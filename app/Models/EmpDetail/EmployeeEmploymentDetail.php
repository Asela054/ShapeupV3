<?php

namespace App\Models\EmpDetail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EmpDetail\Employee;

class EmployeeEmploymentDetail extends Model
{
    use HasFactory;

    protected $table = 'employee_employment_details';
 
    protected $fillable = [
        'emp_id',
        'emp_join_date',
        'emp_permanent_date',
        'emp_assign_date',
        'emp_job_title',
        'emp_company',
        'emp_location',
        'emp_department',
        'emp_shift',
        'job_category_id',
        'hierarchy_id',
        'financial_id',
        'leave_approve_person',
        'outstation_payment',
    ];
 
    /**
     * employee_employment_details.emp_id → employees.id
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'emp_id', 'id');
    }
}
