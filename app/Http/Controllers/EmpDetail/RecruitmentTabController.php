<?php

namespace App\Http\Controllers\EmpDetail;

use App\Http\Controllers\Controller;
use App\Models\EmpDetail\Employee;
use App\Services\EmpDetail\RecruitmentTabService;
use Illuminate\Http\Request;

class RecruitmentTabController extends Controller
{
    protected $service;

    public function __construct(RecruitmentTabService $service)
    {
        $this->service = $service;
    }

    public function show(Employee $employee, Request $request)
    {
        $details = $this->service->getRecruitmentDetails($employee);

        if ($request->wantsJson() || ($request->ajax() && !$request->acceptsHtml())) {
            return response()->json([
                'success'      => true,
                'employee'     => $employee,
                'recruitment'  => $details['recruitment'],
                'interviewers' => $details['interviewers'],
                'photo_url'    => $details['photo_url'],
            ]);
        }

        return view('employee_management.details.tab.recruitment', [
            'emp'          => $employee,
            'employee'     => $employee,
            'recruitment'  => $details['recruitment'],
            'interviewers' => $details['interviewers'],
            'photo_url'    => $details['photo_url'],
        ]);
    }

    public function store(Request $request, Employee $employee)
    {
        return $this->update($request, $employee);
    }

    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'first_interviwer'          => ['nullable'],
            'first_interview_date'      => ['nullable', 'date'],
            'first_interview_outcome'   => ['nullable', 'string', 'max:255'],
            'first_interview_comments'  => ['nullable', 'string'],
            'second_interviewer'        => ['nullable'],
            'second_interview_date'     => ['nullable', 'date'],
            'second_interview_outcome'  => ['nullable', 'string', 'max:255'],
            'second_interview_comments' => ['nullable', 'string'],
            'third_interviewer'         => ['nullable'],
            'third_interview_date'      => ['nullable', 'date'],
            'third_interview_outcome'   => ['nullable', 'string', 'max:255'],
            'third_interview_comments'  => ['nullable', 'string'],
            'status'                    => ['nullable', 'integer'],
        ]);

        $recruitment = $this->service->updateRecruitmentDetails($employee, $validated);

        return response()->json([
            'success' => true,
            'message' => 'Recruitment details updated successfully',
            'id'      => $recruitment->id,
            'data'    => $recruitment,
        ]);
    }
}
