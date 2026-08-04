<?php

namespace App\Http\Controllers\EmpDetail;

use App\Http\Controllers\Controller;
use App\Models\EmpDetail\Employee;
use App\Models\EmpDetail\EmployeeAssignedDevice;
use App\Services\EmpDetail\AssignedDeviceTabService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AssignedDeviceTabController extends Controller
{
    protected $service;

    public function __construct(AssignedDeviceTabService $service)
    {
        $this->service = $service;
    }

    public function show(Employee $employee, Request $request)
    {
        $photoUrl = isset($employee->photograph) && $employee->photograph ? asset('storage/' . $employee->photograph) : null;
        $deviceTypes = $this->service->getDeviceTypes();

        if ($request->wantsJson() && !$request->acceptsHtml()) {
            return response()->json([
                'success'      => true,
                'employee'     => $employee,
                'photo_url'    => $photoUrl,
                'device_types' => $deviceTypes,
            ]);
        }

        return view('employee_management.details.tab.assigned-devices', [
            'emp'          => $employee,
            'employee'     => $employee,
            'photo_url'    => $photoUrl,
            'deviceTypes'  => $deviceTypes,
        ]);
    }

    public function data(Employee $employee)
    {
        $query = $this->service->getAssignedDevicesQuery($employee);

        return DataTables::of($query)
            ->addColumn('device_type_name', function ($row) {
                return $row->deviceType->device_name ?? $row->device_type;
            })
            ->addColumn('device_type', function ($row) {
                return $row->deviceType->device_name ?? $row->device_type;
            })
            ->addColumn('model_number', function ($row) {
                return $row->model_number ?: '-';
            })
            ->addColumn('serial_number', function ($row) {
                return $row->serial_number ?: '-';
            })
            ->addColumn('other_ref_number', function ($row) {
                return $row->other_ref_number ?: '-';
            })
            ->addColumn('assigned_date', function ($row) {
                return $row->assigned_date ?: '-';
            })
            ->addColumn('returned_date', function ($row) {
                return $row->returned_date ?: '-';
            })
            ->addColumn('status', function ($row) {
                if ($row->returned_date || $row->status == 1) {
                    return '<span class="badge badge-light-secondary">Returned</span>';
                }
                return '<span class="badge badge-light-success">Assigned</span>';
            })
            ->rawColumns(['status'])
            ->make(true);
    }

    public function store(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'device_type'      => ['required'],
            'model_number'     => ['required', 'string', 'max:45'],
            'serial_number'    => ['required', 'string', 'max:45'],
            'other_ref_number' => ['nullable', 'string', 'max:45'],
            'assigned_date'    => ['required', 'date'],
            'returned_date'    => ['nullable', 'date'],
            'status'           => ['nullable', 'integer'],
        ]);

        $device = $this->service->store($employee, $validated);

        return response()->json([
            'success' => true,
            'message' => 'Assigned device added successfully',
            'data'    => $device,
        ]);
    }

    public function edit(Employee $employee, EmployeeAssignedDevice $device)
    {
        return response()->json([
            'success' => true,
            'data'    => [
                'id'               => $device->id,
                'device_type'      => $device->device_type,
                'model_number'     => $device->model_number,
                'serial_number'    => $device->serial_number,
                'other_ref_number' => $device->other_ref_number,
                'assigned_date'    => $device->assigned_date,
                'returned_date'    => $device->returned_date,
                'status'           => $device->status,
            ],
        ]);
    }

    public function update(Request $request, Employee $employee, EmployeeAssignedDevice $device)
    {
        $validated = $request->validate([
            'device_type'      => ['required'],
            'model_number'     => ['required', 'string', 'max:45'],
            'serial_number'    => ['required', 'string', 'max:45'],
            'other_ref_number' => ['nullable', 'string', 'max:45'],
            'assigned_date'    => ['required', 'date'],
            'returned_date'    => ['nullable', 'date'],
            'status'           => ['nullable', 'integer'],
        ]);

        $updatedDevice = $this->service->update($device, $validated);

        return response()->json([
            'success' => true,
            'message' => 'Assigned device updated successfully',
            'data'    => $updatedDevice,
        ]);
    }

    public function destroy(Employee $employee, EmployeeAssignedDevice $device)
    {
        $this->service->delete($device);

        return response()->json([
            'success' => true,
            'message' => 'Assigned device deleted successfully',
        ]);
    }
}
