<?php

namespace App\Services\AttendanceLeave\LeaveInformation;

use App\Models\AttendanceLeave\Holiday;
use Illuminate\Support\Facades\DB;

class HolidayService
{
    public function create(array $data): Holiday
    {
        return DB::transaction(function () use ($data) {
            $data['created_by'] = auth()->id() ?? 1;
            $data['updated_by'] = auth()->id() ?? 1;
            $data['status'] = $data['status'] ?? 1;

            if (isset($data['date'])) {
                $data['date'] = date('Y-m-d', strtotime($data['date']));
            }

            return Holiday::create($data);
        });
    }

    public function update(Holiday $holiday, array $data): Holiday
    {
        return DB::transaction(function () use ($holiday, $data) {
            $data['updated_by'] = auth()->id() ?? 1;

            if (isset($data['date'])) {
                $data['date'] = date('Y-m-d', strtotime($data['date']));
            }

            $holiday->update($data);

            return $holiday;
        });
    }

    public function delete(Holiday $holiday): void
    {
        DB::transaction(function () use ($holiday) {
            $holiday->delete();
        });
    }
}
