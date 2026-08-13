<?php

namespace App\Services\AttendanceLeave\LeaveInformation;

use App\Models\AttendanceLeave\HolidayDeduction;
use Illuminate\Support\Facades\DB;

class HolidayDeductionService
{
    public function create(array $data): HolidayDeduction
    {
        return DB::transaction(function () use ($data) {
            $data['created_by'] = auth()->id() ?? 1;
            $data['updated_by'] = auth()->id() ?? 1;
            $data['status'] = $data['status'] ?? 1;

            return HolidayDeduction::create($data);
        });
    }

    public function update(HolidayDeduction $holidayDeduction, array $data): HolidayDeduction
    {
        return DB::transaction(function () use ($holidayDeduction, $data) {
            $data['updated_by'] = auth()->id() ?? 1;

            $holidayDeduction->update($data);

            return $holidayDeduction;
        });
    }

    public function delete(HolidayDeduction $holidayDeduction): void
    {
        DB::transaction(function () use ($holidayDeduction) {
            $holidayDeduction->delete();
        });
    }
}
