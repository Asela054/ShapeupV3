<?php

namespace App\Services\EmpMaster;

use App\Models\EmpMaster\ExamSubject;
use Illuminate\Support\Facades\DB;

class ExamSubjectService
{
    public function create(array $data): ExamSubject
    {
        return DB::transaction(function () use ($data) {
            $data['status'] = $data['status'] ?? 1;
            return ExamSubject::create($data);
        });
    }

    public function update(ExamSubject $examSubject, array $data): ExamSubject
    {
        return DB::transaction(function () use ($examSubject, $data) {
            $examSubject->update($data);

            return $examSubject;
        });
    }

    public function delete(ExamSubject $examSubject): void
    {
        DB::transaction(function () use ($examSubject) {
            $examSubject->delete();
        });
    }
}
