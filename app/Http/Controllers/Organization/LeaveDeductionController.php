<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Models\Organization\LeaveDeduction;
use App\Services\Organization\LeaveDeductionService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LeaveDeductionController extends Controller
{
    protected $service;

    public function __construct(LeaveDeductionService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('organization.leavedeductions');
    }

    public function data(Request $request)
    {
        $deductions = LeaveDeduction::with(['jobCategory', 'remuneration']);

        return DataTables::of($deductions)
            ->addColumn('job_category', fn ($row) => $row->jobCategory->category ?? '')
            ->addColumn('remuneration_name', fn ($row) => $row->remuneration->remuneration_name ?? '')
            ->make(true);
    }

    protected function rules(): array
    {
        return [
            'job_id' => ['required', 'integer', 'exists:job_categories,id'],
            'remuneration_id' => ['required', 'integer', 'exists:remunerations,id'],
            'day_count' => ['required', 'numeric'],
            'amount' => ['required', 'numeric'],
        ];
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        $this->service->create($validated);

        return response()->json(['message' => 'Leave deduction created successfully']);
    }

    public function edit(LeaveDeduction $leaveDeduction)
    {
        return response()->json($leaveDeduction);
    }

    public function update(Request $request, LeaveDeduction $leaveDeduction)
    {
        $validated = $request->validate($this->rules());

        $this->service->update($leaveDeduction, $validated);

        return response()->json(['message' => 'Leave deduction updated successfully']);
    }

    public function destroy(LeaveDeduction $leaveDeduction)
    {
        $this->service->delete($leaveDeduction);

        return response()->json(['message' => 'Leave deduction deleted successfully']);
    }
}
