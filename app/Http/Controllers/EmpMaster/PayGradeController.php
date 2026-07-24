<?php

namespace App\Http\Controllers\EmpMaster;

use App\Http\Controllers\Controller;
use App\Models\EmpMaster\PayGrade;
use App\Services\EmpMaster\PayGradeService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PayGradeController extends Controller
{
    protected $service;

    public function __construct(PayGradeService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('employee_management.masterdata.pay_grade');
    }

    public function data(Request $request)
    {
        $payGrades = PayGrade::query();

        return DataTables::of($payGrades)
            ->addIndexColumn()
            ->make(true);
    }

    protected function rules(?int $payGradeId = null): array
    {
        return [
            'pay_grade' => ['required', 'string', 'max:255', 'unique:pay_grades,pay_grade,' . $payGradeId],
        ];
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        $payGrade = $this->service->create($validated);

        return response()->json(['message' => 'Pay Grade created successfully', 'data' => $payGrade]);
    }

    public function edit(PayGrade $payGrade)
    {
        return response()->json($payGrade);
    }

    public function update(Request $request, PayGrade $payGrade)
    {
        $validated = $request->validate($this->rules($payGrade->id));

        $payGrade = $this->service->update($payGrade, $validated);

        return response()->json(['message' => 'Pay Grade updated successfully', 'data' => $payGrade]);
    }

    public function destroy(PayGrade $payGrade)
    {
        $this->service->delete($payGrade);

        return response()->json(['message' => 'Pay Grade deleted successfully']);
    }
}
