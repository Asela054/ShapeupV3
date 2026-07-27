<?php

namespace App\Services\EmpMaster;

use App\Models\EmpMaster\AssignedDevice;
use Illuminate\Support\Facades\DB;

class AssignedDeviceService
{
    public function create(array $data): AssignedDevice
    {
        return DB::transaction(function () use ($data) {
            return AssignedDevice::create($data);
        });
    }

    public function update(AssignedDevice $assignedDevice, array $data): AssignedDevice
    {
        return DB::transaction(function () use ($assignedDevice, $data) {
            $assignedDevice->update($data);

            return $assignedDevice;
        });
    }

    public function delete(AssignedDevice $assignedDevice): void
    {
        DB::transaction(function () use ($assignedDevice) {
            $assignedDevice->delete();
        });
    }
}
