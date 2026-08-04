<?php

namespace App\Http\Controllers\EmpDetail;

use App\Http\Controllers\Controller;
use App\Models\EmpDetail\Employee;
use App\Services\EmpDetail\EmployeeService;
use App\Services\EmpDetail\PersonalTabService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class EmployeeController extends Controller
{
    protected $service;

    public function __construct(EmployeeService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('employee_management.details.details');
    }

    public function data(Request $request)
    {
        $employees = Employee::query()->where('deleted', 0);

        return DataTables::of($employees)
            ->addColumn('name', function ($row) {
                return $row->emp_name_with_initial;
            })
            ->addColumn('nic', function ($row) {
                return $row->emp_national_id ?? ($row->personalDetail->nic_no ?? '-');
            })
            ->addColumn('etf_no', function ($row) {
                return $row->emp_etf_no ?: '-';
            })
            ->addColumn('department', function ($row) {
                return $row->employmentDetail->department->name ?? '-';
            })
            ->addColumn('join_date', function ($row) {
                return $row->employmentDetail->join_date ?? '-';
            })
            ->addColumn('position', function ($row) {
                return $row->employmentDetail->position->title ?? '-';
            })
            ->addColumn('job_category', function ($row) {
                return $row->employmentDetail->jobCategory->category ?? '-';
            })
            ->addColumn('status', function ($row) {
                return $row->is_resigned
                    ? '<span class="badge badge-light-danger">Resigned</span>'
                    : '<span class="badge badge-light-success">Active</span>';
            })
            ->rawColumns(['status'])
            ->make(true);
    }

    protected function rules(?int $id = null): array
    {
        return [
            'emp_no'                => ['required', 'numeric', 'unique:employees,emp_id,' . ($id ? $id : 'NULL') . ',id'],
            'emp_etfno'             => ['nullable', 'string', 'max:150'],
            'emp_first_name'        => ['required', 'string', 'max:255'],
            'emp_med_name'          => ['nullable', 'string', 'max:255'],
            'emp_last_name'         => ['required', 'string', 'max:255'],
            'emp_fullname'          => ['required', 'string', 'max:450'],
            'emp_name_with_initial' => ['required', 'string', 'max:255'],
            'calling_name'          => ['required', 'string', 'max:255'],
            'emp_national_id'       => ['required', 'string', 'max:255'],
            'emp_birthday'          => ['nullable', 'date'],
            'personal_number'       => ['nullable', 'string', 'max:50'],
            'mobile_number'         => ['nullable', 'string', 'max:50'],
            'office_extension'      => ['nullable', 'string', 'max:50'],
            'photograph'            => ['nullable', 'image', 'max:2048'],
            'emp_status'            => ['nullable', 'string', 'max:50'],
            'emp_job_code'          => ['nullable'],
            'emp_shift'             => ['nullable'],
            'emp_company'           => ['nullable'],
            'emp_department'        => ['nullable'],
            'emp_location'          => ['nullable'],
            'employee_id'           => ['nullable'],
        ];
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        $employee = $this->service->create($validated, $request->file('photograph'));

        return response()->json([
            'success' => true,
            'message' => 'Employee created successfully',
            'data'    => $employee,
        ]);
    }

    public function edit(Employee $employee)
    {
        return response()->json($employee);
    }

    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate($this->rules($employee->id));

        $employee = $this->service->update($employee, $validated, $request->file('photograph'));

        return response()->json([
            'success' => true,
            'message' => 'Employee updated successfully',
            'data'    => $employee,
        ]);
    }

    public function destroy(Employee $employee)
    {
        $this->service->delete($employee);

        return response()->json([
            'success' => true,
            'message' => 'Employee deleted successfully',
        ]);
    }

    public function personal(Employee $employee)
    {
        $service = app(PersonalTabService::class);
        $details = $service->getPersonalDetails($employee);

        return response()->json([
            'success'   => true,
            'employee'  => $details['employee'],
            'photo_url' => $details['photo_url'],
        ]);
    }

    public function updatePersonal(Request $request, Employee $employee)
    {
        $service = app(PersonalTabService::class);
        $validated = $request->validate([
            'emp_first_name'        => ['nullable', 'string', 'max:255'],
            'emp_med_name'          => ['nullable', 'string', 'max:255'],
            'emp_last_name'         => ['nullable', 'string', 'max:255'],
            'emp_name_with_initial' => ['nullable', 'string', 'max:255'],
            'calling_name'          => ['nullable', 'string', 'max:255'],
            'emp_national_id'       => ['nullable', 'string', 'max:255'],
            'emp_fullname'          => ['nullable', 'string', 'max:450'],
        ]);

        $employee = $service->updatePersonalDetails($employee, $validated, $request->file('photograph'));

        return response()->json([
            'success' => true,
            'message' => 'Personal details updated successfully',
            'data'    => $employee,
        ]);
    }

    public function fingerprint(Employee $employee)
    {
        $data = $this->service->getFingerprintData($employee);
        return response()->json(array_merge(['success' => true], $data));
    }

    public function storeFingerprint(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'role'     => ['required', 'string'],
            'location' => ['required'],
            'cardno'   => ['nullable', 'string'],
            'password' => ['nullable', 'string'],
        ]);

        $this->service->storeFingerprint($employee, $validated);

        return response()->json([
            'success' => true,
            'message' => 'Fingerprint details saved successfully',
        ]);
    }

    public function userLogin(Employee $employee)
    {
        $data = $this->service->getUserLoginData($employee);
        return response()->json(array_merge(['success' => true], $data));
    }

    public function storeUserLogin(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'email'    => ['required', 'email', 'max:255'],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ]);

        $this->service->storeUserLogin($employee, $validated);

        return response()->json([
            'success' => true,
            'message' => 'User login saved successfully',
        ]);
    }

    public function resign(Employee $employee)
    {
        return response()->json([
            'success'  => true,
            'employee' => $employee,
        ]);
    }

    public function storeResign(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'resignation_date'   => ['required', 'date'],
            'resignation_remark' => ['nullable', 'string'],
        ]);

        $employee = $this->service->resign($employee, $validated['resignation_date'], $validated['resignation_remark'] ?? null);

        return response()->json([
            'success'  => true,
            'message'  => 'Employee resignation marked successfully',
            'employee' => $employee,
        ]);
    }

    public function undoResign(Employee $employee)
    {
        $employee = $this->service->undoResign($employee);

        return response()->json([
            'success'  => true,
            'message'  => 'Resignation cancelled successfully',
            'employee' => $employee,
        ]);
    }

    public function getTab(Employee $employee, string $key)
    {
        $allowedTabs = [
            'personal', 'emergency-contacts', 'dependents', 'salary',
            'qualifications', 'passport', 'bank', 'files',
            'recruitment', 'exam-result', 'assigned-devices',
        ];

        if (!in_array($key, $allowedTabs)) {
            return response()->make('<p class="text-danger p-4">Invalid tab requested.</p>', 404);
        }

        $viewName = 'employee_management.details.tab.' . $key;

        if (view()->exists($viewName)) {
            return view($viewName, [
                'emp'      => $employee,
                'employee' => $employee,
            ]);
        }

        return response()->make('<p class="text-muted p-4">Tab view coming soon.</p>', 200);
    }
}