<?php

namespace App\Models\EmpMaster;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;

    protected $fillable = [
        'skill',
    ];

    public function employeeSkills()
    {
        return $this->hasMany(\App\Models\EmpDetail\EmployeeSkill::class, 'emp_skill', 'id');
    }
}
