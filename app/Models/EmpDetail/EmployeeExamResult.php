<?php

namespace App\Models\EmpDetail;

use App\Models\EmpMaster\ExamSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EmpDetail\Employee;

class EmployeeExamResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'emp_id',
        'exam_type',
        'subject_id',
        'grade',
        'school',
        'medium',
        'year',
        'center_no',
        'index_no',
        'status',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'emp_id', 'id');
    }

    public function subject()
    {
        return $this->belongsTo(ExamSubject::class, 'subject_id', 'id');
    }
}