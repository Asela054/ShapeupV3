<?php

namespace App\Services\Kpi;

use App\Models\Kpi\KpiYear;
use Illuminate\Support\Facades\DB;

class KpiYearService
{
    public function getAll()
    {
        return KpiYear::orderBy('id', 'desc')->get();
    }

    public function create(array $data): KpiYear
    {
        return DB::transaction(function () use ($data) {
            return KpiYear::create([
                'year_name'  => $data['year_name'],
                'start_date' => $data['start_date'],
                'end_date'   => $data['end_date'],
                'status'     => $data['status'] ?? 'active',
            ]);
        });
    }

    public function update(KpiYear $kpiYear, array $data): KpiYear
    {
        return DB::transaction(function () use ($kpiYear, $data) {
            $kpiYear->update([
                'year_name'  => $data['year_name'],
                'start_date' => $data['start_date'],
                'end_date'   => $data['end_date'],
                'status'     => $data['status'] ?? $kpiYear->status,
            ]);
            return $kpiYear;
        });
    }

    public function toggleStatus(KpiYear $kpiYear, ?string $status = null): KpiYear
    {
        return DB::transaction(function () use ($kpiYear, $status) {
            $newStatus = $status ?: ($kpiYear->status === 'active' ? 'closed' : 'active');
            $kpiYear->update(['status' => $newStatus]);
            return $kpiYear;
        });
    }

    public function delete(KpiYear $kpiYear): void
    {
        DB::transaction(function () use ($kpiYear) {
            $kpiYear->delete();
        });
    }
}
