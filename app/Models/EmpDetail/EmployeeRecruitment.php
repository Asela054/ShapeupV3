<?php

namespace App\Models\EmpDetail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EmpDetail\Employee;

class EmployeeRecruitment extends Model
{
    use HasFactory;

    protected $fillable = [
        'emp_id',
        'first_interviwer',
        'first_interview_date',
        'first_interview_outcome',
        'first_interview_comments',
        'second_interviewer',
        'second_interview_date',
        'second_interview_outcome',
        'second_interview_comments',
        'third_interviewer',
        'third_interview_date',
        'third_interview_outcome',
        'third_interview_comments',
        'status',
        'created_by',
        'updated_by',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'emp_id', 'id');
    }
}