<?php

namespace App\Http\Controllers\EmpMaster;

use App\Http\Controllers\Controller;
use App\Models\EmpMaster\EmploymentStatus;
use App\Services\EmpMaster\EmploymentStatusService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class EmploymentStatusController extends Controller
{
    protected $service;

    public function __construct(EmploymentStatusService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('employee_management.masterdata.employment_status');
    }

    public function data(Request $request)
    {
        $employmentStatuses = EmploymentStatus::query();

        return DataTables::of($employmentStatuses)
            ->addIndexColumn()
            ->make(true);
    }

    protected function rules(?int $employmentStatusId = null): array
    {
        return [
            'emp_status' => ['required', 'string', 'max:255', 'unique:employment_statuses,emp_status,' . $employmentStatusId],
        ];
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        $employmentStatus = $this->service->create($validated);

        return response()->json(['message' => 'Employment Status created successfully', 'data' => $employmentStatus]);
    }

    public function edit(EmploymentStatus $employmentStatus)
    {
        return response()->json($employmentStatus);
    }

    public function update(Request $request, EmploymentStatus $employmentStatus)
    {
        $validated = $request->validate($this->rules($employmentStatus->id));

        $employmentStatus = $this->service->update($employmentStatus, $validated);

        return response()->json(['message' => 'Employment Status updated successfully', 'data' => $employmentStatus]);
    }

    public function destroy(EmploymentStatus $employmentStatus)
    {
        $this->service->delete($employmentStatus);

        return response()->json(['message' => 'Employment Status deleted successfully']);
    }
}
