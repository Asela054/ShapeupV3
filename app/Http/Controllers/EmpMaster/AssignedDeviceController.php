<?php

namespace App\Http\Controllers\EmpMaster;

use App\Http\Controllers\Controller;
use App\Models\EmpMaster\AssignedDevice;
use App\Services\EmpMaster\AssignedDeviceService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AssignedDeviceController extends Controller
{
    protected $service;

    public function __construct(AssignedDeviceService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('employee_management.masterdata.assigned_device');
    }

    public function data(Request $request)
    {
        $assignedDevices = AssignedDevice::query();

        return DataTables::of($assignedDevices)
            ->addIndexColumn()
            ->make(true);
    }

    protected function rules(?int $assignedDeviceId = null): array
    {
        return [
            'device_name' => ['required', 'string', 'max:255', 'unique:assigned_devices,device_name,' . $assignedDeviceId],
            'remarks' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        $assignedDevice = $this->service->create($validated);

        return response()->json(['message' => 'Assigned Device created successfully', 'data' => $assignedDevice]);
    }

    public function edit(AssignedDevice $assignedDevice)
    {
        return response()->json($assignedDevice);
    }

    public function update(Request $request, AssignedDevice $assignedDevice)
    {
        $validated = $request->validate($this->rules($assignedDevice->id));

        $assignedDevice = $this->service->update($assignedDevice, $validated);

        return response()->json(['message' => 'Assigned Device updated successfully', 'data' => $assignedDevice]);
    }

    public function destroy(AssignedDevice $assignedDevice)
    {
        $this->service->delete($assignedDevice);

        return response()->json(['message' => 'Assigned Device deleted successfully']);
    }
}
