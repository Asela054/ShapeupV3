<?php

namespace App\Services\AttendanceLeave\AttendanceInformation;

use App\Models\Attendance\fingerprint_devices;
use Illuminate\Support\Facades\DB;

class FingerprintDeviceService
{
    public function create(array $data): fingerprint_devices
    {
        return DB::transaction(function () use ($data) {
            $data['created_by'] = auth()->id();
            $data['updated_by'] = auth()->id();

            return fingerprint_devices::create($data);
        });
    }

    public function update(fingerprint_devices $device, array $data): fingerprint_devices
    {
        return DB::transaction(function () use ($device, $data) {
            $data['updated_by'] = auth()->id();

            $device->update($data);

            return $device;
        });
    }

    public function delete(fingerprint_devices $device): void
    {
        DB::transaction(function () use ($device) {
            $device->delete();
        });
    }
}