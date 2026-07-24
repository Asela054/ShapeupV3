<?php

namespace App\Services\EmpMaster;

use App\Models\EmpMaster\CompanyHierarchy;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CompanyHierarchyService
{
    public function create(array $data): CompanyHierarchy
    {
        return DB::transaction(function () use ($data) {
            return CompanyHierarchy::create($data);
        });
    }

    public function update(CompanyHierarchy $companyHierarchy, array $data): CompanyHierarchy
    {
        return DB::transaction(function () use ($companyHierarchy, $data) {
            $companyHierarchy->update($data);

            return $companyHierarchy;
        });
    }

    public function delete(CompanyHierarchy $companyHierarchy): void
    {
        DB::transaction(function () use ($companyHierarchy) {
            $companyHierarchy->delete();
        });
    }
}