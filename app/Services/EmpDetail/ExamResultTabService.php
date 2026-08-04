<?php

namespace App\Services\EmpDetail;

use App\Models\EmpDetail\Employee;
use App\Models\EmpDetail\EmployeeExamResult;
use App\Models\EmpMaster\ExamSubject;
use Illuminate\Support\Facades\DB;

class ExamResultTabService
{
    public function getExamResultDetails(Employee $employee): array
    {
        $photoUrl = null;
        if (isset($employee->photograph) && $employee->photograph) {
            $photoUrl = asset('storage/' . $employee->photograph);
        }

        return [
            'photo_url'    => $photoUrl,
            'examSubjects' => $this->getExamSubjectOptions(),
        ];
    }

    public function getExamSubjectOptions(): array
    {
        return ExamSubject::select('id', 'subject', 'exam_type')
            ->orderBy('subject')
            ->get()
            ->toArray();
    }

    public function getExamResultsForDataTable(Employee $employee): array
    {
        return EmployeeExamResult::with('subject')
            ->where('emp_id', $employee->id)
            ->orderByDesc('year')
            ->get()
            ->map(function (EmployeeExamResult $result) {
                return [
                    'id'        => $result->id,
                    'exam_type' => $result->exam_type,
                    'subject'   => $result->subject->subject ?? '',
                    'grade'     => $result->grade,
                    'school'    => $result->school,
                    'medium'    => $result->medium,
                    'year'      => $result->year,
                    'center_no' => $result->center_no,
                    'index_no'  => $result->index_no,
                ];
            })
            ->toArray();
    }

    public function storeExamResults(Employee $employee, array $records): void
    {
        DB::transaction(function () use ($employee, $records) {
            foreach ($records as $record) {
                EmployeeExamResult::create([
                    'emp_id'     => $employee->id,
                    'exam_type'  => $record['exam_type'],
                    'medium'     => $record['medium'],
                    'year'       => $record['year'],
                    'school'     => $record['school'],
                    'center_no'  => $record['center_no'] ?? null,
                    'index_no'   => $record['index_no'] ?? null,
                    'subject_id' => $record['subject_id'],
                    'grade'      => $record['grade'],
                ]);
            }
        });
    }

    public function deleteExamResult(Employee $employee, EmployeeExamResult $examResult): void
    {
        abort_unless($examResult->emp_id === $employee->id, 404);

        $examResult->delete();
    }
}