<?php

namespace App\Http\Controllers\AttendanceLeave\LeaveInformation;

use App\Http\Controllers\Controller;
use App\Models\AttendanceLeave\LeaveRequest;
use App\Models\EmpDetail\Employee;
use App\Services\AttendanceLeave\LeaveInformation\LeaveRequestService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LeaveRequestController extends Controller
{
    protected $service;

    public function __construct(LeaveRequestService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        if ($request->ajax() && $request->has('draw')) {
            return $this->data($request);
        }

        if ($request->ajax()) {
            $employees = Employee::where('emp_status', 1)
                ->orderBy('emp_name_with_initial')
                ->get(['emp_id', 'emp_name_with_initial', 'calling_name']);

            return response()->json(
                $employees->map(fn($e) => [
                    'id'   => $e->emp_id,
                    'text' => $e->emp_name_with_initial . ' - ' . $e->calling_name,
                ])
            );
        }

        return view('attendance_leave.leaveInformation.leave_request');
    }

    public function data(Request $request)
    {
        $query = LeaveRequest::query()
            ->join('employees as emp', 'leave_request.emp_id', '=', 'emp.emp_id')
            ->leftJoin('employee_employment_details as eed', 'emp.id', '=', 'eed.emp_id')
            ->leftJoin('departments', 'eed.emp_department', '=', 'departments.id')
            ->leftJoin('companies as com', 'eed.emp_company', '=', 'com.id')
            ->leftJoin('branches as br', 'eed.emp_location', '=', 'br.id')
            ->leftJoin('leaves', 'leave_request.id', '=', 'leaves.request_id')
            ->leftJoin('leave_types', 'leaves.leave_type', '=', 'leave_types.id')
            ->where('leave_request.status', 1)
            ->select(
                'leave_request.id',
                'leave_request.emp_id',
                'leave_request.from_date',
                'leave_request.to_date',
                'leave_request.leave_category',
                'leave_request.reason',
                'leave_request.approve_status',
                'leave_request.request_approve_status',
                'emp.emp_name_with_initial',
                'emp.calling_name',
                'departments.name as department_name',
                'leave_types.leave_type as leave_type_name',
                'leaves.status as leave_status'
            );

        if ($request->filled('company_id')) {
            $query->where('eed.emp_company', $request->company_id);
        }

        if ($request->filled('department_id')) {
            $query->where('eed.emp_department', $request->department_id);
        }

        if ($request->filled('location_id')) {
            $query->where('eed.emp_location', $request->location_id);
        }

        if ($request->filled('employee_id')) {
            $query->where('leave_request.emp_id', $request->employee_id);
        }

        if ($request->filled('from_date')) {
            $query->whereDate('leave_request.from_date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('leave_request.to_date', '<=', $request->to_date);
        }

        return DataTables::of($query)
            ->addColumn('employee', function ($row) {
                return $row->emp_name_with_initial . ' - ' . $row->calling_name;
            })
            ->addColumn('department', function ($row) {
                return $row->department_name ?? '-';
            })
            ->addColumn('request_leave', function ($row) {
                $map = [
                    'Full Day'    => 'Full Day',
                    'Half Day'    => 'Half Day',
                    'Short Leave' => 'Short Leave',
                ];
                return $map[$row->leave_category] ?? $row->leave_category ?? '-';
            })
            ->addColumn('leave_from', fn($row) => $row->from_date ?? '-')
            ->addColumn('leave_to', fn($row) => $row->to_date ?? '-')
            ->addColumn('leave_type', fn($row) => $row->leave_type_name ?? '-')
            ->addColumn('approved_leave', fn($row) => $row->leave_status ?? '-')
            ->addColumn('leave_approve_status', fn($row) => $row->leave_status ?? '')
            ->addColumn('approve_status_raw', fn($row) => $row->approve_status)
            ->make(true);
    }

    protected function rules(?int $id = null): array
    {
        return [
            'emp_id'      => ['required', 'string'],
            'leave_type'  => ['required', 'string'],
            'from_date'   => ['required', 'string'],
            'to_date'     => ['required', 'string'],
            'half_short'  => ['required', 'string'],
            'from_time'   => ['nullable', 'string'],
            'to_time'     => ['nullable', 'string'],
            'reason'      => ['nullable', 'string', 'max:500'],
            'covering_emp_id' => ['nullable', 'string'],
        ];
    }

    protected function mapPayload(array $data): array
    {
        return [
            'emp_id'                 => $data['emp_id'],
            'leave_type'             => $data['leave_type'],
            'from_date'              => $data['from_date'],
            'to_date'                => $data['to_date'],
            'leave_category'         => $data['half_short'],
            'from_time'              => $data['from_time'] ?? null,
            'to_time'                => $data['to_time'] ?? null,
            'reason'                 => $data['reason'] ?? null,
            'covering_emp_id'        => $data['covering_emp_id'] ?? null,
        ];
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        $leaveRequest = $this->service->create($this->mapPayload($validated));

        return response()->json([
            'message' => 'Leave request created successfully',
            'data'    => $leaveRequest,
        ]);
    }

    public function edit(LeaveRequest $leaveRequest)
    {
        return response()->json([
            'id'            => $leaveRequest->id,
            'emp_id'        => $leaveRequest->emp_id,
            'employee_name' => optional($leaveRequest->employee)->emp_name_with_initial,
            'leave_type'    => $leaveRequest->leave_type,
            'from_date'     => $leaveRequest->from_date,
            'to_date'       => $leaveRequest->to_date,
            'half_short'    => $leaveRequest->leave_category,
            'from_time'     => $leaveRequest->from_time,
            'to_time'       => $leaveRequest->to_time,
            'reason'        => $leaveRequest->reason,
        ]);
    }

    public function update(Request $request, LeaveRequest $leaveRequest)
    {
        $validated = $request->validate($this->rules($leaveRequest->id));

        $leaveRequest = $this->service->update($leaveRequest, $this->mapPayload($validated));

        return response()->json([
            'message' => 'Leave request updated successfully',
            'data'    => $leaveRequest,
        ]);
    }

    public function destroy(LeaveRequest $leaveRequest)
    {
        $this->service->delete($leaveRequest);

        return response()->json([
            'message' => 'Leave request deleted successfully',
        ]);
    }

    public function approve(Request $request, LeaveRequest $leaveRequest)
    {
        $leaveRequest = $this->service->approve($leaveRequest);

        return response()->json([
            'message' => 'Leave request approved successfully',
            'data'    => $leaveRequest,
        ]);
    }

    public function leaveBalance(string $empId)
    {
        $balance = $this->service->getLeaveBalance($empId);

        return response()->json($balance);
    }
}

