<?php

namespace App\Models\Organization;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EmpDetail\Employee;
use App\Models\Organization\Company;

class Branch extends Model
{
    use HasFactory;

    protected $table = 'branches';

    protected $fillable = [
        'company_id',
        'branch_head_emp_id',
        'location',
        'code',
        'epf',
        'contactno',
        'etf',
        'latitude',
        'longitude',
        'outside_location',
    ];

    /**
     * companies.id → branches.company_id
     */
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    /**
     * employees.id → branches.branch_head_emp_id
     */
    public function branchHead()
    {
        return $this->belongsTo(Employee::class, 'branch_head_emp_id', 'id');
    }
}