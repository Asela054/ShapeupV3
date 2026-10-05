<?php

namespace App\Services\Kpi;

use App\Models\Kpi\KpiCategory;
use Illuminate\Support\Facades\DB;

class KpiCategoryService
{
    public function getAll()
    {
        return KpiCategory::with('parent')->get();
    }

    public function create(array $data): KpiCategory
    {
        return DB::transaction(function () use ($data) {
            return KpiCategory::create([
                'name'        => $data['name'],
                'parent_id'   => $data['parent_id'] ?? null,
                'description' => $data['description'] ?? null,
            ]);
        });
    }

    public function update(KpiCategory $kpiCategory, array $data): KpiCategory
    {
        return DB::transaction(function () use ($kpiCategory, $data) {
            $kpiCategory->update([
                'name'        => $data['name'],
                'parent_id'   => $data['parent_id'] ?? null,
                'description' => $data['description'] ?? null,
            ]);
            return $kpiCategory;
        });
    }

    public function delete(KpiCategory $kpiCategory): void
    {
        DB::transaction(function () use ($kpiCategory) {
            $kpiCategory->delete();
        });
    }
}
