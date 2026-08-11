<?php

namespace App\Services\ShiftManagement;

use App\Models\ShiftManagement\ShiftType;
use Illuminate\Support\Facades\DB;

class WorkShiftService
{
    public function create(array $data): ShiftType
    {
        return DB::transaction(function () use ($data) {
            $data['created_by'] = auth()->id() ?? 1;
            $data['updated_by'] = auth()->id() ?? 1;
            $data['status'] = $data['status'] ?? 1;
            $data['deleted'] = $data['deleted'] ?? 0;

            return ShiftType::create($data);
        });
    }

    public function update(ShiftType $workShift, array $data): ShiftType
    {
        return DB::transaction(function () use ($workShift, $data) {
            $data['updated_by'] = auth()->id() ?? 1;

            $workShift->update($data);

            return $workShift;
        });
    }

    public function delete(ShiftType $workShift): void
    {
        DB::transaction(function () use ($workShift) {
            $workShift->delete();
        });
    }
}
