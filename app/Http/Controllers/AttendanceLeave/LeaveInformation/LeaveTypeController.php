<?php

namespace App\Http\Controllers\AttendanceLeave\LeaveInformation;

use App\Http\Controllers\Controller;
use App\Models\AttendanceLeave\LeaveType;
use App\Services\AttendanceLeave\LeaveInformation\LeaveTypeService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LeaveTypeController extends Controller
{
    protected $service;

    public function __construct(LeaveTypeService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->data($request);
        }

        return view('attendance_leave.leaveInformation.leave_type');
    }

    public function data(Request $request)
    {
        $query = LeaveType::query();

        return DataTables::of($query)
            ->make(true);
    }

    protected function rules(?int $id = null): array
    {
        return [
            'leave_type' => ['required', 'string', 'max:255'],
            'emp_status' => ['nullable', 'string', 'max:255'],
            'assigned_leave' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        $leaveType = $this->service->create($validated);

        return response()->json([
            'message' => 'Leave type created successfully',
            'data' => $leaveType,
        ]);
    }

    public function edit(LeaveType $leaveType)
    {
        return response()->json($leaveType);
    }

    public function update(Request $request, LeaveType $leaveType)
    {
        $validated = $request->validate($this->rules($leaveType->id));

        $leaveType = $this->service->update($leaveType, $validated);

        return response()->json([
            'message' => 'Leave type updated successfully',
            'data' => $leaveType,
        ]);
    }

    public function destroy(LeaveType $leaveType)
    {
        $this->service->delete($leaveType);

        return response()->json([
            'message' => 'Leave type deleted successfully',
        ]);
    }
}
