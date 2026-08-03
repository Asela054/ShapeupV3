<?php

namespace App\Services\EmpDetail;

use App\Models\EmpDetail\Employee;
use App\Models\EmpDetail\EmployeeAssignedDevice;
use App\Models\EmpMaster\AssignedDevice;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AssignedDeviceTabService
{
    public function getAssignedDevicesQuery(Employee $employee)
    {
        return EmployeeAssignedDevice::with('deviceType')
            ->where('emp_id', $employee->id);
    }

    public function getDeviceTypes()
    {
        return AssignedDevice::all();
    }

    public function store(Employee $employee, array $data): EmployeeAssignedDevice
    {
        return DB::transaction(function () use ($employee, $data) {
            return EmployeeAssignedDevice::create([
                'emp_id'           => $employee->id,
                'device_type'      => $data['device_type'],
                'model_number'     => $data['model_number'],
                'serial_number'    => $data['serial_number'],
                'other_ref_number' => $data['other_ref_number'] ?? null,
                'assigned_date'    => $data['assigned_date'],
                'returned_date'    => $data['returned_date'] ?? null,
                'status'           => $data['status'] ?? 0,
            ]);
        });
    }

    public function find(int $id): ?EmployeeAssignedDevice
    {
        return EmployeeAssignedDevice::find($id);
    }

    public function update(EmployeeAssignedDevice $device, array $data): EmployeeAssignedDevice
    {
        return DB::transaction(function () use ($device, $data) {
            $device->update([
                'device_type'      => $data['device_type'] ?? $device->device_type,
                'model_number'     => $data['model_number'] ?? $device->model_number,
                'serial_number'    => $data['serial_number'] ?? $device->serial_number,
                'other_ref_number' => array_key_exists('other_ref_number', $data) ? $data['other_ref_number'] : $device->other_ref_number,
                'assigned_date'    => $data['assigned_date'] ?? $device->assigned_date,
                'returned_date'    => array_key_exists('returned_date', $data) ? $data['returned_date'] : $device->returned_date,
                'status'           => $data['status'] ?? $device->status,
            ]);

            return $device->fresh();
        });
    }

    public function delete(EmployeeAssignedDevice $device): ?bool
    {
        return DB::transaction(function () use ($device) {
            return $device->delete();
        });
    }
}
