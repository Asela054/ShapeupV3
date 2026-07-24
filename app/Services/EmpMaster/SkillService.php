<?php

namespace App\Services\EmpMaster;

use App\Models\EmpMaster\Skill;
use Illuminate\Support\Facades\DB;

class SkillService
{
    public function create(array $data): Skill
    {
        return DB::transaction(function () use ($data) {
            return Skill::create($data);
        });
    }

    public function update(Skill $skill, array $data): Skill
    {
        return DB::transaction(function () use ($skill, $data) {
            $skill->update($data);

            return $skill;
        });
    }

    public function delete(Skill $skill): void
    {
        DB::transaction(function () use ($skill) {
            $skill->delete();
        });
    }
}