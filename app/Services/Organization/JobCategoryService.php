<?php

namespace App\Services\Organization;

use App\Models\Organization\JobCategory;
use Illuminate\Support\Facades\DB;

class JobCategoryService
{
    public function create(array $data): JobCategory
    {
        return DB::transaction(function () use ($data) {
            $data['created_by'] = auth()->id();
            $data['updated_by'] = auth()->id();

            return JobCategory::create($data);
        });
    }

    public function update(JobCategory $jobCategory, array $data): JobCategory
    {
        return DB::transaction(function () use ($jobCategory, $data) {
            $data['updated_by'] = auth()->id();

            $jobCategory->update($data);

            return $jobCategory;
        });
    }

    public function delete(JobCategory $jobCategory): void
    {
        DB::transaction(function () use ($jobCategory) {
            $jobCategory->delete();
        });
    }
}