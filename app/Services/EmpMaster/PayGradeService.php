<?php

namespace App\Services\EmpMaster;

use App\Models\EmpMaster\PayGrade;
use Illuminate\Support\Facades\DB;

class PayGradeService
{
    public function create(array $data): PayGrade
    {
        return DB::transaction(function () use ($data) {
            return PayGrade::create($data);
        });
    }

    public function update(PayGrade $payGrade, array $data): PayGrade
    {
        return DB::transaction(function () use ($payGrade, $data) {
            $payGrade->update($data);

            return $payGrade;
        });
    }

    public function delete(PayGrade $payGrade): void
    {
        DB::transaction(function () use ($payGrade) {
            $payGrade->delete();
        });
    }
}
