<?php

namespace App\Services\AttendanceLeave\AttendanceInformation;

use App\Models\Attendance\fingerprint_users;
use Illuminate\Support\Facades\DB;

class FingerprintUserService
{
    public function update(fingerprint_users $fingerprintUser, array $data): fingerprint_users
    {
        return DB::transaction(function () use ($fingerprintUser, $data) {
            $data['updated_by'] = auth()->id();

            $fingerprintUser->update($data);

            return $fingerprintUser->fresh();
        });
    }

    public function delete(fingerprint_users $fingerprintUser): void
    {
        DB::transaction(function () use ($fingerprintUser) {
            $fingerprintUser->delete();
        });
    }
}