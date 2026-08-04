<?php

namespace App\Services\EmpDetail;

use App\Models\EmpDetail\Employee;
use App\Models\EmpDetail\EmployeeBank;
use App\Models\Organization\Bank;
use App\Models\Organization\BankBranch;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class BankTabService
{
    public function getBankDetails(Employee $employee): array
    {
        $photoUrl = null;
        if (isset($employee->photograph) && $employee->photograph) {
            $photoUrl = asset('storage/' . $employee->photograph);
        }

        $banks = collect();
        $branches = [];

        try {
            if (Schema::hasTable('banks')) {
                $banks = Bank::select('code', 'name')->orderBy('name')->get();
            }
        } catch (\Throwable $e) {
            $banks = collect();
        }

        // Fallback 
        if ($banks->isEmpty()) {
            $banks = collect([
                (object)['code' => '7010', 'name' => 'Bank of Ceylon'],
                (object)['code' => '7056', 'name' => 'Commercial Bank of Ceylon'],
                (object)['code' => '7135', 'name' => 'Peoples Bank'],
                (object)['code' => '7278', 'name' => 'Sampath Bank'],
                (object)['code' => '7083', 'name' => 'Hatton National Bank'],
                (object)['code' => '7092', 'name' => 'Seylan Bank'],
                (object)['code' => '7162', 'name' => 'Nations Trust Bank'],
                (object)['code' => '7205', 'name' => 'DFCC Bank'],
                (object)['code' => '7117', 'name' => 'National Savings Bank'],
                (object)['code' => '7463', 'name' => 'Amana Bank'],
            ]);
        }

        try {
            if (Schema::hasTable('bank_branches')) {
                $branches = BankBranch::select('code', 'branch_name as branch', 'bank_code as bankcode')->orderBy('branch_name')->get()->toArray();
            }
        } catch (\Throwable $e) {
            $branches = [];
        }

        // Fallback 
        if (empty($branches)) {
            $branches = [
                ['code' => '001', 'branch' => 'Head Office / Main Branch', 'bankcode' => '7010'],
                ['code' => '002', 'branch' => 'Colombo Fort', 'bankcode' => '7010'],
                ['code' => '001', 'branch' => 'Main Branch', 'bankcode' => '7056'],
                ['code' => '002', 'branch' => 'City Office', 'bankcode' => '7056'],
                ['code' => '001', 'branch' => 'Head Office', 'bankcode' => '7135'],
                ['code' => '001', 'branch' => 'Head Office', 'bankcode' => '7278'],
                ['code' => '001', 'branch' => 'Head Office', 'bankcode' => '7083'],
            ];
        }

        return [
            'employee'  => $employee,
            'photo_url' => $photoUrl,
            'banks'     => $banks,
            'branches'  => $branches,
        ];
    }

    public function getBankQuery(Employee $employee)
    {
        try {
            if (!Schema::hasTable('employee_banks')) {
                return EmployeeBank::query()->whereRaw('1 = 0');
            }

            $query = EmployeeBank::query()->where('emp_id', $employee->id)->orderByDesc('id');

            if (Schema::hasTable('banks')) {
                $query->with('bank');
            }
            if (Schema::hasTable('bank_branches')) {
                $query->with('branch');
            }

            return $query;
        } catch (\Throwable $e) {
            return EmployeeBank::query()->whereRaw('1 = 0');
        }
    }

    public function storeBank(Employee $employee, array $data): EmployeeBank
    {
        return EmployeeBank::create(array_merge($data, [
            'emp_id' => $employee->id,
            'status' => $data['status'] ?? 1,
        ]));
    }

    public function updateBank(EmployeeBank $bank, array $data): EmployeeBank
    {
        $bank->update($data);
        return $bank->fresh();
    }

    public function deleteBank(EmployeeBank $bank): void
    {
        $bank->delete();
    }
}
