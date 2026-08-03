<?php

namespace App\Http\Controllers\EmpMaster;

use App\Http\Controllers\Controller;
use App\Models\EmpMaster\ExamSubject;
use App\Services\EmpMaster\ExamSubjectService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ExamSubjectController extends Controller
{
    protected $service;

    public function __construct(ExamSubjectService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('employee_management.masterdata.exam_subject');
    }

    public function data(Request $request)
    {
        $examSubjects = ExamSubject::query();

        if ($request->filled('exam_type')) {
            $examSubjects->where('exam_type', $request->exam_type);
        }

        return DataTables::of($examSubjects)
            ->addIndexColumn()
            ->make(true);
    }

    protected function rules(?int $examSubjectId = null): array
    {
        return [
            'exam_type' => ['required', 'string', 'max:45'],
            'subject' => ['required', 'string', 'max:255'],
            'status' => ['nullable', 'integer'],
        ];
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());
        $validated['status'] = $validated['status'] ?? 1;

        $examSubject = $this->service->create($validated);

        return response()->json(['message' => 'Exam Subject created successfully', 'data' => $examSubject]);
    }

    public function edit(ExamSubject $examSubject)
    {
        return response()->json($examSubject);
    }

    public function update(Request $request, ExamSubject $examSubject)
    {
        $validated = $request->validate($this->rules($examSubject->id));

        $examSubject = $this->service->update($examSubject, $validated);

        return response()->json(['message' => 'Exam Subject updated successfully', 'data' => $examSubject]);
    }

    public function destroy(ExamSubject $examSubject)
    {
        $this->service->delete($examSubject);

        return response()->json(['message' => 'Exam Subject deleted successfully']);
    }
}
