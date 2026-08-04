<?php

namespace App\Services\EmpDetail;

use App\Models\EmpDetail\Employee;
use App\Models\EmpDetail\EmployeeEducation;
use App\Models\EmpDetail\EmployeeExperience;
use App\Models\EmpDetail\EmployeeSkill;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class QualificationTabService
{
    public function getQualificationDetails(Employee $employee): array
    {
        $photoUrl = null;
        if (isset($employee->photograph) && $employee->photograph) {
            $photoUrl = asset('storage/' . $employee->photograph);
        }

        return [
            'photo_url' => $photoUrl,
        ];
    }

    // ── Work Experience ──
    public function getExperienceForEmployee(Employee $employee)
    {
        return EmployeeExperience::where('emp_id', $employee->id)->get();
    }

    public function storeExperience(Employee $employee, array $data): EmployeeExperience
    {
        return EmployeeExperience::create(array_merge($data, [
            'emp_id' => $employee->id,
        ]));
    }

    public function updateExperience(EmployeeExperience $experience, array $data): EmployeeExperience
    {
        $experience->update($data);
        return $experience;
    }

    public function deleteExperience(EmployeeExperience $experience): void
    {
        $experience->delete();
    }

    // ── Higher Education ──
    public function getEducationForEmployee(Employee $employee)
    {
        return EmployeeEducation::where('emp_id', $employee->id)->get();
    }

    public function storeEducation(Employee $employee, array $data): EmployeeEducation
    {
        return EmployeeEducation::create(array_merge($data, [
            'emp_id' => $employee->id,
        ]));
    }

    public function updateEducation(EmployeeEducation $education, array $data): EmployeeEducation
    {
        $education->update($data);
        return $education;
    }

    public function deleteEducation(EmployeeEducation $education): void
    {
        $education->delete();
    }

    // ── Skills ──
    public function getSkillsForEmployee(Employee $employee)
    {
        return EmployeeSkill::where('emp_id', $employee->id)->get();
    }

    public function storeSkill(Employee $employee, array $data): EmployeeSkill
    {
        return EmployeeSkill::create(array_merge($data, [
            'emp_id' => $employee->id,
        ]));
    }

    public function updateSkill(EmployeeSkill $skill, array $data): EmployeeSkill
    {
        $skill->update($data);
        return $skill;
    }

    public function deleteSkill(EmployeeSkill $skill): void
    {
        $skill->delete();
    }
}
