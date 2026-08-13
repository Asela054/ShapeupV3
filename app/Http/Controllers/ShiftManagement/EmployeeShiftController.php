<?php

namespace App\Http\Controllers\ShiftManagement;

use App\Http\Controllers\Controller;
use App\Models\EmpDetail\Employee;
use App\Models\Organization\Branch;
use App\Models\Organization\Company;
use App\Models\Organization\Department;
use App\Models\ShiftManagement\Shift;
use App\Models\ShiftManagement\ShiftType;
use App\Services\ShiftManagement\EmployeeShiftService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class EmployeeShiftController extends Controller
{
    protected $service;

    public function __construct(EmployeeShiftService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $shifts = ShiftType::all();
        $companies = Company::orderBy('name')->get();
        $departments = Department::orderBy('name')->get();
        $employees = Employee::select('id', 'emp_id', 'calling_name', 'emp_name_with_initial')->get();

        return view('shift_management.employee_shifts', compact('shifts', 'companies', 'departments', 'employees'));
    }

    public function data(Request $request)
    {
        $query = Shift::with(['employee.employmentDetail', 'shiftType']);

        if ($request->filled('emp_id')) {
            $query->where('emp_id', $request->emp_id);
        }

        if ($request->filled('company_id') || $request->filled('department_id') || $request->filled('location_id')) {
            $query->whereHas('employee.employmentDetail', function ($q) use ($request) {
                if ($request->filled('company_id')) {
                    $q->where('emp_company', $request->company_id);
                }
                if ($request->filled('department_id')) {
                    $q->where('emp_department', $request->department_id);
                }
                if ($request->filled('location_id')) {
                    $q->where('emp_location', $request->location_id);
                }
            });
        }

        return DataTables::of($query)
            ->addColumn('employee_name', function ($row) {
                if ($row->employee) {
                    return $row->employee->calling_name ?: $row->employee->emp_name_with_initial;
                }
                return $row->emp_id;
            })
            ->addColumn('department', function ($row) {
                if ($row->employee && $row->employee->employmentDetail) {
                    $deptId = $row->employee->employmentDetail->emp_department;
                    $dept = Department::find($deptId);
                    return $dept ? $dept->name : '-';
                }
                return '-';
            })
            ->addColumn('shift', function ($row) {
                if ($row->shiftType) {
                    return $row->shiftType->shift_name;
                }
                return $row->shift_id;
            })
            ->editColumn('start_time', function ($row) {
                if (!empty($row->start_time)) {
                    return $row->start_time;
                }
                return $row->shiftType ? $row->shiftType->onduty_time : '-';
            })
            ->editColumn('end_time', function ($row) {
                if (!empty($row->end_time)) {
                    return $row->end_time;
                }
                return $row->shiftType ? $row->shiftType->offduty_time : '-';
            })
            ->make(true);
    }

    protected function rules(?int $id = null): array
    {
        return [
            'emp_id' => ['required', 'string', 'max:255'],
            'shift_id' => ['required', 'string', 'max:255'],
            'shift_location' => ['nullable', 'string', 'max:255'],
            'start_time' => ['nullable', 'string', 'max:255'],
            'end_time' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', 'integer'],
        ];
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        $shiftType = ShiftType::find($validated['shift_id']);
        if ($shiftType) {
            $validated['start_time'] = $validated['start_time'] ?? $shiftType->onduty_time;
            $validated['end_time'] = $validated['end_time'] ?? $shiftType->offduty_time;
        }

        $shift = $this->service->create($validated);

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Shift created successfully', 'data' => $shift]);
        }

        return redirect()->back()->with('success', 'Employee shift created successfully');
    }

    public function edit(Shift $employeeShift)
    {
        $employeeShift->load(['employee', 'shiftType']);

        $employeeName = '-';
        if ($employeeShift->employee) {
            $employeeName = $employeeShift->employee->calling_name ?: $employeeShift->employee->emp_name_with_initial;
        }

        return response()->json([
            'id' => $employeeShift->id,
            'emp_id' => $employeeShift->emp_id,
            'employee_name' => $employeeName,
            'shift_id' => $employeeShift->shift_id,
            'shift_location' => $employeeShift->shift_location,
            'start_time' => $employeeShift->start_time,
            'end_time' => $employeeShift->end_time,
            'status' => $employeeShift->status,
        ]);
    }

    public function update(Request $request, Shift $employeeShift)
    {
        $validated = $request->validate($this->rules($employeeShift->id));

        $shiftType = ShiftType::find($validated['shift_id']);
        if ($shiftType) {
            $validated['start_time'] = $validated['start_time'] ?? $shiftType->onduty_time;
            $validated['end_time'] = $validated['end_time'] ?? $shiftType->offduty_time;
        }

        $updatedShift = $this->service->update($employeeShift, $validated);

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Shift updated successfully', 'data' => $updatedShift]);
        }

        return redirect()->back()->with('success', 'Employee shift updated successfully');
    }

    public function destroy(Shift $employeeShift)
    {
        $this->service->delete($employeeShift);

        return response()->json(['message' => 'Employee shift deleted successfully']);
    }
}
