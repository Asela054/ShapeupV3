<?php

namespace App\Models\EmpDetail;

use App\Models\EmpMaster\Skill;
use App\Models\EmpDetail\Employee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeSkill extends Model
{
    use HasFactory;

    protected $fillable = [
        'emp_id',
        'emp_skill',
        'emp_experience',
        'emp_comment',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'emp_id', 'id');
    }

    public function skill()
    {
        return $this->belongsTo(Skill::class, 'emp_skill', 'id');
    }
}
