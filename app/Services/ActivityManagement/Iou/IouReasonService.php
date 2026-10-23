<?php

namespace App\Services\ActivityManagement\Iou;

use App\Models\ActivityManagement\Iou\IouReason;
use Illuminate\Support\Facades\DB;

// Service = where the real database work happenning here
class IouReasonService
{
    public function create(array $data): IouReason
    {
        // Saves a new reason
        return DB::transaction(function () use ($data) {
            $data['status'] = 1; // active on create

            return IouReason::create($data);
        });
    }

    // Updates an existing reason with the validated form data
    public function update(IouReason $iouReason, array $data): IouReason
    {
        return DB::transaction(function () use ($iouReason, $data) {
            $iouReason->update($data);

            return $iouReason;
        });
    }

    // Doesn't remove the row, just sets status to 3
    public function delete(IouReason $iouReason): void
    {
        DB::transaction(function () use ($iouReason) {
            $iouReason->update(['status' => 3]); // soft delete
        });
    }
}