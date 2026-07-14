<?php

namespace App\Models\EmpDetail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EmpDetail\Employee;

class EmployeePassport extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'emp_id',
        'emp_pass_issue_date',
        'emp_pass_expire_date',
        'emp_pass_comments',
        'emp_pass_type',
        'emp_pass_status',
        'emp_pass_review',
        'epf_no',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'emp_id', 'id');
    }
}