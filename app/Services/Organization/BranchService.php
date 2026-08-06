<?php

namespace App\Services\Organization;

use App\Models\Organization\Branch;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BranchService
{
    public function create(array $data): Branch
    {
        return DB::transaction(function () use ($data) {
            $data['outside_location'] = isset($data['outside_location']) && $data['outside_location'] ? 1 : 0;

            return Branch::create($data);
        });
    }

    public function update(Branch $branch, array $data): Branch
    {
        return DB::transaction(function () use ($branch, $data) {
            $data['outside_location'] = isset($data['outside_location']) && $data['outside_location'] ? 1 : 0;

            $branch->update($data);

            return $branch;
        });
    }

    public function delete(Branch $branch): void
    {
        DB::transaction(function () use ($branch) {
            $branch->delete();
        });
    }
}
