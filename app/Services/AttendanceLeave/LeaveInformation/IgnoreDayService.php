<?php

namespace App\Services\AttendanceLeave\LeaveInformation;

use App\Models\AttendanceLeave\IgnoreDay;
use Illuminate\Support\Facades\DB;

class IgnoreDayService
{
    public function create(array $data): array
    {
        return DB::transaction(function () use ($data) {
            $month = $data['month'];
            
            // Format month to full YYYY-MM-01 date if provided as YYYY-MM
            if (strlen($month) === 7) {
                $month = $month . '-01';
            } else {
                $month = date('Y-m-01', strtotime($month));
            }

            $dates = $data['dates'];
            if (is_string($dates)) {
                $dates = array_map('trim', explode(',', $dates));
            }

            $createdRecords = [];
            $userId = auth()->id() ?? 1;

            foreach ($dates as $dateStr) {
                if (empty($dateStr)) {
                    continue;
                }

                $formattedDate = date('Y-m-d', strtotime($dateStr));

                // Check if ignore day already exists 
                $record = IgnoreDay::updateOrCreate(
                    [
                        'date' => $formattedDate,
                    ],
                    [
                        'month' => $month,
                        'status' => $data['status'] ?? 1,
                        'created_by' => $userId,
                        'updated_by' => $userId,
                    ]
                );

                $createdRecords[] = $record;
            }

            return $createdRecords;
        });
    }

    public function update(IgnoreDay $ignoreDay, array $data): IgnoreDay
    {
        return DB::transaction(function () use ($ignoreDay, $data) {
            $data['updated_by'] = auth()->id() ?? 1;

            if (isset($data['month']) && strlen($data['month']) === 7) {
                $data['month'] = $data['month'] . '-01';
            } elseif (isset($data['month'])) {
                $data['month'] = date('Y-m-01', strtotime($data['month']));
            }

            if (isset($data['date'])) {
                $data['date'] = date('Y-m-d', strtotime($data['date']));
            }

            $ignoreDay->update($data);

            return $ignoreDay;
        });
    }

    public function delete(IgnoreDay $ignoreDay): void
    {
        DB::transaction(function () use ($ignoreDay) {
            $ignoreDay->delete();
        });
    }
}
