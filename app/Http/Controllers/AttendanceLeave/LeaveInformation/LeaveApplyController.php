<?php

namespace App\Http\Controllers\AttendanceLeave\LeaveInformation;

use App\Http\Controllers\Controller;
use App\Models\AttendanceLeave\Leave;
use App\Models\EmpDetail\Employee;
use App\Services\AttendanceLeave\LeaveInformation\LeaveApplyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class LeaveApplyController extends Controller
{
    protected $service;

    public function __construct(LeaveApplyService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        if ($request->ajax() && $request->has('draw')) {
            return $this->data($request);
        }

        return view('attendance_leave.leaveInformation.leave_apply');
    }

    public function lookup()
    {
        $employees = Employee::where('emp_status', 1)
            ->orderBy('emp_name_with_initial')
            ->get(['emp_id', 'emp_name_with_initial', 'calling_name']);

        $companies = DB::table('companies')
            ->where('status', 1)
            ->get(['id', 'name']);

        $departments = DB::table('departments')
            ->get(['id', 'name']);

        $locations = DB::table('branches')
            ->get(['id', 'name']);

        return response()->json([
            'employees' => $employees->map(fn($e) => [
                'id'   => $e->emp_id,
                'text' => $e->emp_name_with_initial . ' - ' . $e->calling_name,
            ]),
            'companies' => $companies->map(fn($c) => [
                'id'   => $c->id,
                'text' => $c->name,
            ]),
            'departments' => $departments->map(fn($d) => [
                'id'   => $d->id,
                'text' => $d->name,
            ]),
            'locations' => $locations->map(fn($l) => [
                'id'   => $l->id,
                'text' => $l->name,
            ]),
        ]);
    }

    public function data(Request $request)
    {
        $query = Leave::query()
            ->join('employees as e', 'leaves.emp_id', '=', 'e.emp_id')
            ->leftJoin('employees as ec', 'leaves.emp_covering', '=', 'ec.emp_id')
            ->leftJoin('employee_employment_details as eed', 'e.id', '=', 'eed.emp_id')
            ->leftJoin('departments', 'eed.emp_department', '=', 'departments.id')
            ->leftJoin('companies as com', 'eed.emp_company', '=', 'com.id')
            ->leftJoin('branches as br', 'eed.emp_location', '=', 'br.id')
            ->leftJoin('leave_types', 'leaves.leave_type', '=', 'leave_types.id')
            ->select(
                'leaves.id',
                'leaves.emp_id',
                'leaves.leave_type',
                'leaves.leave_from',
                'leaves.leave_to',
                'leaves.no_of_days',
                'leaves.half_short',
                'leaves.reason',
                'leaves.emp_covering',
                'leaves.leave_approve_person',
                'leaves.leave_category',
                'leaves.status',
                'leaves.request_id',
                'e.emp_name_with_initial',
                'e.calling_name',
                'ec.emp_name_with_initial as covering_emp_name',
                'departments.name as department_name',
                'leave_types.leave_type as leave_type_name'
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
            $query->where('leaves.emp_id', $request->employee_id);
        }

        if ($request->filled('from_date')) {
            $query->whereDate('leaves.leave_from', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('leaves.leave_to', '<=', $request->to_date);
        }

        return DataTables::of($query)
            ->addColumn('employee', function ($row) {
                return $row->emp_name_with_initial . ' - ' . $row->calling_name;
            })
            ->addColumn('department', fn($row) => $row->department_name ?? '-')
            ->addColumn('leave_type', fn($row) => $row->leave_type_name ?? '-')
            ->addColumn('covering_person', fn($row) => $row->covering_emp_name ?? '-')
            ->addColumn('status_raw', fn($row) => $row->status)
            ->make(true);
    }

    protected function rules(?int $id = null): array
    {
        return [
            'emp_id'            => ['required', 'string'],
            'leave_type'        => ['required', 'string'],
            'from_date'         => ['required', 'date'],
            'to_date'           => ['required', 'date'],
            'half_short'        => ['required', 'string'],
            'no_of_days'        => ['nullable', 'numeric'],
            'reason'            => ['nullable', 'string', 'max:500'],
            'covering_emp_id'   => ['nullable', 'string'],
            'approve_person_id' => ['nullable', 'string'],
            'leave_request_id'  => ['nullable', 'integer'],
        ];
    }

    protected function mapPayload(array $data): array
    {
        return [
            'emp_id'               => $data['emp_id'],
            'leave_type'           => $data['leave_type'],
            'leave_from'           => $data['from_date'],
            'leave_to'             => $data['to_date'],
            'no_of_days'           => $data['no_of_days'] ?? null,
            'half_short'           => $data['half_short'],
            'reason'               => $data['reason'] ?? null,
            'emp_covering'         => $data['covering_emp_id'] ?? null,
            'leave_approve_person' => $data['approve_person_id'] ?? null,
            'leave_category'       => $data['half_short'],
            'request_id'           => $data['leave_request_id'] ?? null,
        ];
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        $leave = $this->service->create($this->mapPayload($validated));

        return response()->json([
            'message' => 'Leave applied successfully',
            'data'    => $leave,
        ]);
    }

    public function edit(Leave $leaveApply)
    {
        return response()->json([
            'id'                  => $leaveApply->id,
            'emp_id'              => $leaveApply->emp_id,
            'employee'            => optional($leaveApply->employee)->emp_name_with_initial,
            'leave_type'          => $leaveApply->leave_type,
            'from_date'           => $leaveApply->leave_from,
            'to_date'             => $leaveApply->leave_to,
            'no_of_days'          => $leaveApply->no_of_days,
            'half_short'          => $leaveApply->half_short,
            'reason'              => $leaveApply->reason,
            'covering_emp_id'     => $leaveApply->emp_covering,
            'covering_emp_name'   => optional($leaveApply->covering_employee)->emp_name_with_initial,
            'approve_person_id'   => $leaveApply->leave_approve_person,
            'approve_person_name' => optional($leaveApply->approve_by)->emp_name_with_initial,
            'leave_category'      => $leaveApply->leave_category,
            'status'              => $leaveApply->status,
            'request_id'          => $leaveApply->request_id,
        ]);
    }

    public function update(Request $request, Leave $leaveApply)
    {
        $validated = $request->validate($this->rules($leaveApply->id));

        $leaveApply = $this->service->update($leaveApply, $this->mapPayload($validated));

        return response()->json([
            'message' => 'Leave updated successfully',
            'data'    => $leaveApply,
        ]);
    }

    public function destroy(Leave $leaveApply)
    {
        $this->service->delete($leaveApply);

        return response()->json([
            'message' => 'Leave deleted successfully',
        ]);
    }

    public function leaveBalance(string $empId)
    {
        $balance = $this->service->getLeaveBalance($empId);

        return response()->json($balance);
    }
}
