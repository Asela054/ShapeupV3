<?php

namespace App\Services\ShiftManagement;

use App\Models\ShiftManagement\Shift;
use Illuminate\Support\Facades\DB;

class EmployeeShiftService
{
    public function create(array $data): Shift
    {
        return DB::transaction(function () use ($data) {
            $data['created_by'] = auth()->id() ?? 1;
            $data['updated_by'] = auth()->id() ?? 1;
            $data['status'] = $data['status'] ?? 1;

            return Shift::create($data);
        });
    }

    public function update(Shift $shift, array $data): Shift
    {
        return DB::transaction(function () use ($shift, $data) {
            $data['updated_by'] = auth()->id() ?? 1;

            $shift->update($data);

            return $shift;
        });
    }

    public function delete(Shift $shift): void
    {
        DB::transaction(function () use ($shift) {
            $shift->delete();
        });
    }
}
