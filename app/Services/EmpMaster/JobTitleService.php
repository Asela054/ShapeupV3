<?php

namespace App\Services\EmpMaster;

use App\Models\EmpMaster\JobTitle;
use Illuminate\Support\Facades\DB;

class JobTitleService
{
    public function create(array $data): JobTitle
    {
        return DB::transaction(function () use ($data) {
            return JobTitle::create($data);
        });
    }

    public function update(JobTitle $jobTitle, array $data): JobTitle
    {
        return DB::transaction(function () use ($jobTitle, $data) {
            $jobTitle->update($data);

            return $jobTitle;
        });
    }

    public function delete(JobTitle $jobTitle): void
    {
        DB::transaction(function () use ($jobTitle) {
            $jobTitle->delete();
        });
    }
}
