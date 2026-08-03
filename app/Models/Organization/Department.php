<?php

namespace App\Models\Organization;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EmpDetail\Employee;

class Department extends Model
{
    use HasFactory;

    protected $table = 'departments';

    protected $fillable = [
        'company_id',
        'name',
        'dep_head_emp_id',
        'created_by',
        'updated_by',
    ];

    /**
     * companies.id → departments.company_id
     */
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    /**
     * employees.id → departments.dep_head_emp_id
     */
    public function departmentHead()
    {
        return $this->belongsTo(Employee::class, 'dep_head_emp_id', 'id');
    }
}