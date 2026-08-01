<?php

namespace App\Services\EmpMaster;

use App\Models\EmpMaster\FinancialCategory;
use Illuminate\Support\Facades\DB;

class FinancialCategoryService
{
    public function create(array $data): FinancialCategory
    {
        return DB::transaction(function () use ($data) {
            return FinancialCategory::create($data);
        });
    }

    public function update(FinancialCategory $financialCategory, array $data): FinancialCategory
    {
        return DB::transaction(function () use ($financialCategory, $data) {
            $financialCategory->update($data);

            return $financialCategory;
        });
    }

    public function delete(FinancialCategory $financialCategory): void
    {
        DB::transaction(function () use ($financialCategory) {
            $financialCategory->delete();
        });
    }
}
