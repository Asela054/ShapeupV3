<?php

namespace App\Models\EmpMaster;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamSubject extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_type',
        'subject',
        'status',
        'created_by',
        'updated_by',
    ];

    public function examResults()
    {
        return $this->hasMany(\App\Models\EmpDetail\EmployeeExamResult::class, 'subject_id', 'id');
    }
}
