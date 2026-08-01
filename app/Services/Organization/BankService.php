<?php

namespace App\Services\Organization;

use App\Models\Organization\Bank;
use App\Models\Organization\BankBranch;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BankService
{
    public function create(array $data): Bank
    {
        return DB::transaction(function () use ($data) {
            $data['create_by'] = auth()->id();
            $data['update_by'] = auth()->id();
            $data['status'] = $data['status'] ?? 1;

            return Bank::create($data);
        });
    }

    public function update(Bank $bank, array $data): Bank
    {
        return DB::transaction(function () use ($bank, $data) {
            $data['update_by'] = auth()->id();
            $bank->update($data);

            return $bank;
        });
    }

    public function delete(Bank $bank): void
    {
        DB::transaction(function () use ($bank) {
            BankBranch::where('bankcode', $bank->code)->delete();
            $bank->delete();
        });
    }

    public function createBranch(Bank $bank, array $data): BankBranch
    {
        return DB::transaction(function () use ($bank, $data) {
            $data['bankcode'] = $bank->code;
            $data['create_by'] = auth()->id();
            $data['update_by'] = auth()->id();
            $data['status'] = $data['status'] ?? 1;

            return BankBranch::create($data);
        });
    }

    public function updateBranch(BankBranch $branch, array $data): BankBranch
    {
        return DB::transaction(function () use ($branch, $data) {
            $data['update_by'] = auth()->id();
            $branch->update($data);

            return $branch;
        });
    }

    public function deleteBranch(BankBranch $branch): void
    {
        DB::transaction(function () use ($branch) {
            $branch->delete();
        });
    }
}