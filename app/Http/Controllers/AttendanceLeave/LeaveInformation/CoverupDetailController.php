<?php

namespace App\Http\Controllers\AttendanceLeave\LeaveInformation;

use App\Http\Controllers\Controller;
use App\Models\AttendanceLeave\CoverupDetail;
use App\Models\EmpDetail\Employee;
use App\Models\Organization\Company;
use App\Models\Organization\Department;
use App\Models\Organization\Branch;
use App\Services\AttendanceLeave\LeaveInformation\CoverupDetailService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CoverupDetailController extends Controller
{
    protected $service;

    public function __construct(CoverupDetailService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->data($request);
        }

        $companies = Company::all();
        $departments = Department::all();
        $locations = Branch::all();
        $employees = Employee::all();

        return view('attendance_leave.leaveInformation.coverup_details', compact('companies', 'departments', 'locations', 'employees'));
    }

    public function data(Request $request)
    {
        $query = CoverupDetail::with(['employee.employmentDetail']);

        if ($request->filled('company_id')) {
            $query->whereHas('employee.employmentDetail', function ($q) use ($request) {
                $q->where('emp_company', $request->company_id);
            });
        }

        if ($request->filled('department_id')) {
            $query->whereHas('employee.employmentDetail', function ($q) use ($request) {
                $q->where('emp_department', $request->department_id);
            });
        }

        if ($request->filled('location_id')) {
            $query->whereHas('employee.employmentDetail', function ($q) use ($request) {
                $q->where('emp_location', $request->location_id);
            });
        }

        if ($request->filled('emp_id')) {
            $query->where('emp_id', $request->emp_id);
        }

        if ($request->filled('from_date')) {
            $query->whereDate('date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('date', '<=', $request->to_date);
        }

        return DataTables::of($query)
            ->addColumn('employee_name', function ($row) {
                return $row->employee->emp_name_with_initial ?? $row->employee->calling_name ?? '-';
            })
            ->addColumn('department', function ($row) {
                return $row->employee->employmentDetail->emp_department ?? '-';
            })
            ->editColumn('date', function ($row) {
                return $row->date ? date('Y-m-d', strtotime($row->date)) : '-';
            })
            ->editColumn('start_time', function ($row) {
                return $row->start_time ? date('h:i A', strtotime($row->start_time)) : '-';
            })
            ->editColumn('end_time', function ($row) {
                return $row->end_time ? date('h:i A', strtotime($row->end_time)) : '-';
            })
            ->editColumn('covering_hours', function ($row) {
                return $row->covering_hours;
            })
            ->make(true);
    }

    protected function rules(): array
    {
        return [
            'covering_emp_id' => ['required', 'integer'],
            'covering_date' => ['required', 'string'],
            'start_time' => ['required', 'string'],
            'end_time' => ['required', 'string'],
        ];
    }

    protected function mapPayload(array $data): array
    {
        $startTime = date('H:i:s', strtotime($data['start_time']));
        $endTime = date('H:i:s', strtotime($data['end_time']));
        $startSec = strtotime($startTime);
        $endSec = strtotime($endTime);
        $coveringHours = round(abs($endSec - $startSec) / 3600, 2);

        return [
            'emp_id' => $data['covering_emp_id'],
            'date' => date('Y-m-d', strtotime($data['covering_date'])),
            'start_time' => $startTime,
            'end_time' => $endTime,
            'covering_hours' => $coveringHours,
        ];
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        $coverupDetail = $this->service->create($this->mapPayload($validated));

        return response()->json(['message' => 'Covering detail created successfully', 'data' => $coverupDetail]);
    }

    public function edit(CoverupDetail $coverupDetail)
    {
        return response()->json([
            'id' => $coverupDetail->id,
            'emp_id' => $coverupDetail->emp_id,
            'date' => $coverupDetail->date ? date('m/d/Y', strtotime($coverupDetail->date)) : '',
            'start_time' => $coverupDetail->start_time ? date('h:i A', strtotime($coverupDetail->start_time)) : '',
            'end_time' => $coverupDetail->end_time ? date('h:i A', strtotime($coverupDetail->end_time)) : '',
            'covering_hours' => $coverupDetail->covering_hours,
        ]);
    }

    public function update(Request $request, CoverupDetail $coverupDetail)
    {
        $validated = $request->validate($this->rules());

        $coverupDetail = $this->service->update($coverupDetail, $this->mapPayload($validated));

        return response()->json(['message' => 'Covering detail updated successfully', 'data' => $coverupDetail]);
    }

    public function destroy(CoverupDetail $coverupDetail)
    {
        $this->service->delete($coverupDetail);

        return response()->json(['message' => 'Covering detail deleted successfully']);
    }
}
