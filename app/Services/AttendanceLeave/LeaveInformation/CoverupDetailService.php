<?php

namespace App\Services\AttendanceLeave\LeaveInformation;

use App\Models\AttendanceLeave\CoverupDetail;
use Illuminate\Support\Facades\DB;

class CoverupDetailService
{
    public function create(array $data): CoverupDetail
    {
        return DB::transaction(function () use ($data) {
            $data['created_by'] = auth()->id() ?? 1;
            $data['updated_by'] = auth()->id() ?? 1;
            $data['status'] = $data['status'] ?? 1;

            return CoverupDetail::create($data);
        });
    }

    public function update(CoverupDetail $coverupDetail, array $data): CoverupDetail
    {
        return DB::transaction(function () use ($coverupDetail, $data) {
            $data['updated_by'] = auth()->id() ?? 1;

            $coverupDetail->update($data);

            return $coverupDetail;
        });
    }

    public function delete(CoverupDetail $coverupDetail): void
    {
        DB::transaction(function () use ($coverupDetail) {
            $coverupDetail->delete();
        });
    }
}
