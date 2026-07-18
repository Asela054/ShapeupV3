<?php

namespace App\Services\Organization;

use App\Models\Organization\Company;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CompanyService
{
    public function create(array $data, $logo = null, array $banks = []): Company
    {
        return DB::transaction(function () use ($data, $logo, $banks) {
            if ($logo) {
                $data['logo'] = $logo->store('company-logos', 'public');
            }

            $data['created_by'] = auth()->id();
            $data['updated_by'] = auth()->id();

            $company = Company::create($data);
            $this->syncBankDetails($company, $banks);

            return $company->load('bankDetails');
        });
    }

    public function update(Company $company, array $data, $logo = null, array $banks = []): Company
    {
        return DB::transaction(function () use ($company, $data, $logo, $banks) {
            if ($logo) {
                if ($company->logo) {
                    Storage::disk('public')->delete($company->logo);
                }
                $data['logo'] = $logo->store('company-logos', 'public');
            }

            $data['updated_by'] = auth()->id();

            $company->update($data);
            $this->syncBankDetails($company, $banks);

            return $company->load('bankDetails');
        });
    }

    public function delete(Company $company): void
    {
        DB::transaction(function () use ($company) {
            if ($company->logo) {
                Storage::disk('public')->delete($company->logo);
            }
            $company->bankDetails()->delete();
            $company->delete();
        });
    }

    protected function syncBankDetails(Company $company, array $banks): void
    {
        $company->bankDetails()->delete();

        foreach ($banks as $bank) {
            if (empty($bank['bank_account_number'])) {
                continue;
            }

            $company->bankDetails()->create([
                'bank_code' => $bank['bank_code'] ?? null,
                'branch_code' => $bank['branch_code'] ?? null,
                'bank_account_number' => $bank['bank_account_number'],
                'bank_account_name' => $bank['bank_account_name'] ?? null,
                'status' => 1,
                'created_by' => auth()->id(),
                'updated_by' => auth()->id(),
            ]);
        }
    }
}