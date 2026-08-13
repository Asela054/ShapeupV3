<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Models\Organization\Company;
use App\Models\Organization\Department;
use App\Models\EmpDetail\Employee;
use App\Services\Organization\DepartmentService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DepartmentController extends Controller
{
    protected $service;

    public function __construct(DepartmentService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $companies = Company::orderBy('name')->get();
        $employees = Employee::select('id', 'calling_name', 'full_name')->get();
        $selectedCompanyId = $request->get('company_id');

        return view('organization.department', compact('companies', 'employees', 'selectedCompanyId'));
    }

    public function data(Request $request)
    {
        $query = Department::with(['company', 'departmentHead']);

        if ($request->has('company_id') && !empty($request->company_id)) {
            $query->where('company_id', $request->company_id);
        }

        return DataTables::of($query)
            ->addColumn('head', function ($row) {
                if ($row->departmentHead) {
                    return $row->departmentHead->calling_name ?: $row->departmentHead->full_name;
                }
                return '-';
            })
            ->make(true);
    }

    protected function rules(?int $departmentId = null): array
    {
        return [
            'company_id' => ['required', 'exists:companies,id'],
            'name' => ['required', 'string', 'max:150'],
            'dep_head_emp_id' => ['nullable', 'integer'],
        ];
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        $department = $this->service->create($validated);

        return response()->json(['message' => 'Department created successfully', 'data' => $department]);
    }

    public function edit(Department $department)
    {
        return response()->json($department->load(['company', 'departmentHead']));
    }

    public function update(Request $request, Department $department)
    {
        $validated = $request->validate($this->rules($department->id));

        $department = $this->service->update($department, $validated);

        return response()->json(['message' => 'Department updated successfully', 'data' => $department]);
    }

    public function destroy(Department $department)
    {
        $this->service->delete($department);

        return response()->json(['message' => 'Department deleted successfully']);
    }
}
