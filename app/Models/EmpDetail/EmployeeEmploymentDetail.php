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

    /**
     * employee_employment_details.emp_department → departments.id
     */
    public function department()
    {
        return $this->belongsTo(\App\Models\Organization\Department::class, 'emp_department', 'id');
    }

    /**
     * employee_employment_details.emp_location → branches.id
     */
    public function location()
    {
        return $this->belongsTo(\App\Models\Organization\Branch::class, 'emp_location', 'id');
    }

    /**
     * employee_employment_details.emp_company → companies.id
     */
    public function company()
    {
        return $this->belongsTo(\App\Models\Organization\Company::class, 'emp_company', 'id');
    }

    /**
     * employee_employment_details.job_category_id → job_categories.id
     */
    public function jobCategory()
    {
        return $this->belongsTo(\App\Models\Organization\JobCategory::class, 'job_category_id', 'id');
    }

    /**
     * employee_employment_details.emp_job_title → job_titles.id
     */
    public function jobTitle()
    {
        return $this->belongsTo(\App\Models\EmpMaster\JobTitle::class, 'emp_job_title', 'id');
    }
}
