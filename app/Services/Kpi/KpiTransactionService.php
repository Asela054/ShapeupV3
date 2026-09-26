<?php

namespace App\Services\Kpi;

use App\Models\Kpi\KpiTransaction;
use Illuminate\Support\Facades\DB;

class KpiTransactionService
{
    public function create(array $data): KpiTransaction
    {
        return DB::transaction(function () use ($data) {
            $data['points_snapshot'] = (float) ($data['points_snapshot'] ?? 0);
            $data['quantity'] = (int) ($data['quantity'] ?? 1);
            $data['total_adjustment'] = $data['points_snapshot'] * $data['quantity'];

            return KpiTransaction::create($data);
        });
    }

    public function update(KpiTransaction $kpiTransaction, array $data): KpiTransaction
    {
        return DB::transaction(function () use ($kpiTransaction, $data) {
            $pointsSnapshot = isset($data['points_snapshot']) ? (float) $data['points_snapshot'] : $kpiTransaction->points_snapshot;
            $quantity = isset($data['quantity']) ? (int) $data['quantity'] : $kpiTransaction->quantity;

            $data['points_snapshot'] = $pointsSnapshot;
            $data['quantity'] = $quantity;
            $data['total_adjustment'] = $pointsSnapshot * $quantity;

            $kpiTransaction->update($data);

            return $kpiTransaction;
        });
    }

    public function delete(KpiTransaction $kpiTransaction): void
    {
        DB::transaction(function () use ($kpiTransaction) {
            $kpiTransaction->delete();
        });
    }
}
