<?php

namespace App\Http\Controllers\EmpDetail;

use App\Http\Controllers\Controller;
use App\Models\EmpDetail\Employee;
use App\Models\EmpDetail\EmployeeExamResult;
use App\Services\EmpDetail\ExamResultTabService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ExamResultTabController extends Controller
{
    protected $service;

    public function __construct(ExamResultTabService $service)
    {
        $this->service = $service;
    }

    public function show(Employee $employee, Request $request)
    {
        $details = $this->service->getExamResultDetails($employee);

        if ($request->wantsJson() && !$request->acceptsHtml()) {
            return response()->json([
                'success'      => true,
                'employee'     => $employee,
                'photo_url'    => $details['photo_url'],
                'examSubjects' => $details['examSubjects'],
            ]);
        }

        return view('employee_management.details.tab.exam-result', [
            'emp'          => $employee,
            'employee'     => $employee,
            'photo_url'    => $details['photo_url'],
            'examSubjects' => $details['examSubjects'],
        ]);
    }

    public function data(Employee $employee)
    {
        $rows = $this->service->getExamResultsForDataTable($employee);

        return response()->json([
            'data' => $rows,
        ]);
    }

    public function store(Request $request, Employee $employee)
    {
        $records = json_decode($request->input('records', '[]'), true) ?: [];

        if (empty($records)) {
            return response()->json([
                'success' => false,
                'message' => 'No records provided.',
            ], 422);
        }

        foreach ($records as $record) {
            $validator = validator($record, [
                'exam_type'  => ['required', 'string', 'max:20'],
                'medium'     => ['required'],
                'year'       => ['required', 'string', 'max:10'],
                'school'     => ['required', 'string', 'max:255'],
                'center_no'  => ['nullable', 'string', 'max:50'],
                'index_no'   => ['nullable', 'string', 'max:50'],
                'subject_id' => ['required'],
                'grade'      => ['required', 'string', 'max:10'],
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first(),
                ], 422);
            }
        }

        $this->service->storeExamResults($employee, $records);

        return response()->json([
            'success' => true,
            'message' => 'Exam result(s) saved successfully',
        ]);
    }

    public function destroy(Employee $employee, EmployeeExamResult $examResult)
    {
        $this->service->deleteExamResult($employee, $examResult);

        return response()->json([
            'success' => true,
            'message' => 'Exam result deleted successfully',
        ]);
    }
}