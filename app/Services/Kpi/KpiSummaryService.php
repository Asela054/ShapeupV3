<?php

namespace App\Services\Kpi;

use App\Models\Kpi\KpiSummary;
use Illuminate\Support\Facades\DB;

class KpiSummaryService
{
    public function create(array $data): KpiSummary
    {
        return DB::transaction(function () use ($data) {
            return KpiSummary::updateOrCreate(
                [
                    'employee_id' => $data['employee_id'],
                    'year_id'     => $data['year_id'] ?? 1,
                ],
                [
                    'base_points' => $data['base_points'],
                ]
            );
        });
    }

    public function bulkCreate(array $employeeIds, int $yearId, float $basePoints): array
    {
        return DB::transaction(function () use ($employeeIds, $yearId, $basePoints) {
            $records = [];
            foreach ($employeeIds as $empId) {
                $records[] = KpiSummary::updateOrCreate(
                    [
                        'employee_id' => $empId,
                        'year_id'     => $yearId,
                    ],
                    [
                        'base_points' => $basePoints,
                    ]
                );
            }
            return $records;
        });
    }

    public function update(KpiSummary $kpiSummary, array $data): KpiSummary
    {
        return DB::transaction(function () use ($kpiSummary, $data) {
            $kpiSummary->update($data);
            return $kpiSummary;
        });
    }

    public function delete(KpiSummary $kpiSummary): void
    {
        DB::transaction(function () use ($kpiSummary) {
            $kpiSummary->delete();
        });
    }
}
