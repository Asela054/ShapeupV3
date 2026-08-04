<?php

namespace App\Http\Controllers\EmpDetail;

use App\Http\Controllers\Controller;
use App\Models\EmpDetail\Employee;
use App\Models\EmpDetail\EmployeeEducation;
use App\Models\EmpDetail\EmployeeExperience;
use App\Models\EmpDetail\EmployeeSkill;
use App\Services\EmpDetail\QualificationTabService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class QualificationTabController extends Controller
{
    protected $service;

    public function __construct(QualificationTabService $service)
    {
        $this->service = $service;
    }

    public function show(Employee $employee, Request $request)
    {
        $details = $this->service->getQualificationDetails($employee);

        if ($request->wantsJson() && !$request->acceptsHtml()) {
            return response()->json([
                'success'   => true,
                'employee'  => $employee,
                'photo_url' => $details['photo_url'],
            ]);
        }

        return view('employee_management.details.tab.qualifications', [
            'emp'       => $employee,
            'employee'  => $employee,
            'photo_url' => $details['photo_url'],
        ]);
    }

    // ── Work Experience ──
    public function getExperience(Employee $employee)
    {
        $items = $this->service->getExperienceForEmployee($employee);
        return response()->json(['success' => true, 'data' => $items]);
    }

    public function storeExperience(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'emp_company'   => ['required', 'string', 'max:255'],
            'emp_jobtitle'  => ['required', 'string', 'max:255'],
            'emp_from_date' => ['nullable', 'date'],
            'emp_to_date'   => ['nullable', 'date'],
            'emp_comment'   => ['nullable', 'string'],
        ]);

        $item = $this->service->storeExperience($employee, $validated);

        return response()->json([
            'success' => true,
            'message' => 'Work experience added successfully',
            'data'    => $item,
        ]);
    }

    public function editExperience(Employee $employee, EmployeeExperience $experience)
    {
        return response()->json(['success' => true, 'data' => $experience]);
    }

    public function updateExperience(Request $request, Employee $employee, EmployeeExperience $experience)
    {
        $validated = $request->validate([
            'emp_company'   => ['required', 'string', 'max:255'],
            'emp_jobtitle'  => ['required', 'string', 'max:255'],
            'emp_from_date' => ['nullable', 'date'],
            'emp_to_date'   => ['nullable', 'date'],
            'emp_comment'   => ['nullable', 'string'],
        ]);

        $item = $this->service->updateExperience($experience, $validated);

        return response()->json([
            'success' => true,
            'message' => 'Work experience updated successfully',
            'data'    => $item,
        ]);
    }

    public function destroyExperience(Employee $employee, EmployeeExperience $experience)
    {
        $this->service->deleteExperience($experience);
        return response()->json(['success' => true, 'message' => 'Work experience deleted successfully']);
    }

    // ── Higher Education ──
    public function getEducation(Employee $employee)
    {
        $items = $this->service->getEducationForEmployee($employee);
        return response()->json(['success' => true, 'data' => $items]);
    }

    public function storeEducation(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'emp_level'         => ['required', 'string', 'max:255'],
            'emp_institute'     => ['required', 'string', 'max:255'],
            'emp_specification' => ['nullable', 'string', 'max:255'],
            'emp_year'          => ['nullable', 'string', 'max:50'],
            'emp_gpa'           => ['nullable', 'string', 'max:50'],
        ]);

        $item = $this->service->storeEducation($employee, $validated);

        return response()->json([
            'success' => true,
            'message' => 'Higher education added successfully',
            'data'    => $item,
        ]);
    }

    public function editEducation(Employee $employee, EmployeeEducation $education)
    {
        return response()->json(['success' => true, 'data' => $education]);
    }

    public function updateEducation(Request $request, Employee $employee, EmployeeEducation $education)
    {
        $validated = $request->validate([
            'emp_level'         => ['required', 'string', 'max:255'],
            'emp_institute'     => ['required', 'string', 'max:255'],
            'emp_specification' => ['nullable', 'string', 'max:255'],
            'emp_year'          => ['nullable', 'string', 'max:50'],
            'emp_gpa'           => ['nullable', 'string', 'max:50'],
        ]);

        $item = $this->service->updateEducation($education, $validated);

        return response()->json([
            'success' => true,
            'message' => 'Higher education updated successfully',
            'data'    => $item,
        ]);
    }

    public function destroyEducation(Employee $employee, EmployeeEducation $education)
    {
        $this->service->deleteEducation($education);
        return response()->json(['success' => true, 'message' => 'Higher education deleted successfully']);
    }

    // ── Skills ──
    public function getSkill(Employee $employee)
    {
        $items = $this->service->getSkillsForEmployee($employee);
        return response()->json(['success' => true, 'data' => $items]);
    }

    public function storeSkill(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'emp_skill'      => ['required', 'string', 'max:255'],
            'emp_experience' => ['nullable', 'string', 'max:255'],
            'emp_comment'    => ['nullable', 'string'],
        ]);

        $item = $this->service->storeSkill($employee, $validated);

        return response()->json([
            'success' => true,
            'message' => 'Skill added successfully',
            'data'    => $item,
        ]);
    }

    public function editSkill(Employee $employee, EmployeeSkill $skill)
    {
        return response()->json(['success' => true, 'data' => $skill]);
    }

    public function updateSkill(Request $request, Employee $employee, EmployeeSkill $skill)
    {
        $validated = $request->validate([
            'emp_skill'      => ['required', 'string', 'max:255'],
            'emp_experience' => ['nullable', 'string', 'max:255'],
            'emp_comment'    => ['nullable', 'string'],
        ]);

        $item = $this->service->updateSkill($skill, $validated);

        return response()->json([
            'success' => true,
            'message' => 'Skill updated successfully',
            'data'    => $item,
        ]);
    }

    public function destroySkill(Employee $employee, EmployeeSkill $skill)
    {
        $this->service->deleteSkill($skill);
        return response()->json(['success' => true, 'message' => 'Skill deleted successfully']);
    }
}
