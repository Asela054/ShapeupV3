<?php

namespace App\Services\EmpDetail;

use App\Models\EmpDetail\Employee;
use App\Models\EmpDetail\EmployeeRecruitment;
use Illuminate\Support\Facades\DB;

class RecruitmentTabService
{
    public function getRecruitmentDetails(Employee $employee): array
    {
        $recruitment = $employee->recruitment;

        $photoUrl = null;
        if (isset($employee->photograph) && $employee->photograph) {
            $photoUrl = asset('storage/' . $employee->photograph);
        }

        $interviewers = Employee::where('deleted', 0)
            ->select('id', 'emp_id', 'calling_name', 'emp_name_with_initial')
            ->orderBy('emp_name_with_initial', 'asc')
            ->get();

        return [
            'employee'     => $employee,
            'recruitment'  => $recruitment,
            'interviewers' => $interviewers,
            'photo_url'    => $photoUrl,
        ];
    }

    public function updateRecruitmentDetails(Employee $employee, array $data): EmployeeRecruitment
    {
        return DB::transaction(function () use ($employee, $data) {
            $recruitment = EmployeeRecruitment::where('emp_id', $employee->id)->first();

            $attributes = [
                'first_interviwer'          => $data['first_interviwer'] ?? null,
                'first_interview_date'      => $data['first_interview_date'] ?? null,
                'first_interview_outcome'   => $data['first_interview_outcome'] ?? null,
                'first_interview_comments'  => $data['first_interview_comments'] ?? null,
                'second_interviewer'         => $data['second_interviewer'] ?? null,
                'second_interview_date'     => $data['second_interview_date'] ?? null,
                'second_interview_outcome'  => $data['second_interview_outcome'] ?? null,
                'second_interview_comments' => $data['second_interview_comments'] ?? null,
                'third_interviewer'          => $data['third_interviewer'] ?? null,
                'third_interview_date'      => $data['third_interview_date'] ?? null,
                'third_interview_outcome'   => $data['third_interview_outcome'] ?? null,
                'third_interview_comments'  => $data['third_interview_comments'] ?? null,
                'status'                    => isset($data['status']) ? (int) $data['status'] : 1,
                'updated_by'                => auth()->id(),
            ];

            if ($recruitment) {
                $recruitment->update($attributes);
            } else {
                $attributes['emp_id']     = $employee->id;
                $attributes['created_by'] = auth()->id() ?? 1;
                $recruitment = EmployeeRecruitment::create($attributes);
            }

            return $recruitment;
        });
    }
}
