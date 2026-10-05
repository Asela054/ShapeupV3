<?php

namespace App\Services\Kpi;

use App\Models\Kpi\KpiAttribute;
use Illuminate\Support\Facades\DB;

class KpiAttributeService
{
    public function create(array $data): KpiAttribute
    {
        return DB::transaction(function () use ($data) {
            return KpiAttribute::create($data);
        });
    }

    public function update(KpiAttribute $kpiAttribute, array $data): KpiAttribute
    {
        return DB::transaction(function () use ($kpiAttribute, $data) {
            $kpiAttribute->update($data);
            return $kpiAttribute;
        });
    }

    public function delete(KpiAttribute $kpiAttribute): void
    {
        DB::transaction(function () use ($kpiAttribute) {
            $kpiAttribute->delete();
        });
    }
}
