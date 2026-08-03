<?php

namespace App\Services\EmpDetail;

use App\Models\EmpDetail\Employee;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class EmployeeService
{
    public function create(array $data, $photograph = null): Employee
    {
        return DB::transaction(function () use ($data, $photograph) {
            $photoPath = null;
            if ($photograph) {
                $photoPath = $photograph->store('employee-photos', 'public');
            }

            $employeeData = [
                'emp_id'                => $data['emp_no'],
                'emp_fp_id'             => $data['emp_no'],
                'emp_etf_no'            => $data['emp_etfno'] ?? '',
                'service_no'            => (string) $data['emp_no'],
                'emp_epf_no'            => $data['emp_etfno'] ?? '',
                'emp_name_with_initial' => $data['emp_name_with_initial'],
                'calling_name'          => $data['calling_name'],
                'emp_status'            => isset($data['emp_status']) ? (int) $data['emp_status'] : 1,
                'is_resigned'           => 0,
                'deleted'               => 0,
                'created_by'            => auth()->id(),
            ];

            if ($photoPath && Schema::hasColumn('employees', 'photograph')) {
                $employeeData['photograph'] = $photoPath;
            }

            $employee = Employee::create($employeeData);

            return $employee;
        });
    }

    public function update(Employee $employee, array $data, $photograph = null): Employee
    {
        return DB::transaction(function () use ($employee, $data, $photograph) {
            if ($photograph) {
                if (isset($employee->photograph) && $employee->photograph) {
                    Storage::disk('public')->delete($employee->photograph);
                }
                $photoPath = $photograph->store('employee-photos', 'public');
                if (Schema::hasColumn('employees', 'photograph')) {
                    $data['photograph'] = $photoPath;
                }
            }

            $updateData = [
                'emp_id'                => $data['emp_no'],
                'emp_etf_no'            => $data['emp_etfno'] ?? $employee->emp_etf_no,
                'emp_name_with_initial' => $data['emp_name_with_initial'],
                'calling_name'          => $data['calling_name'],
                'modified_user_id'      => auth()->id(),
            ];

            if (isset($data['emp_status'])) {
                $updateData['emp_status'] = (int) $data['emp_status'];
            }

            $employee->update($updateData);

            return $employee;
        });
    }

    public function delete(Employee $employee): void
    {
        DB::transaction(function () use ($employee) {
            $employee->update(['deleted' => 1]);
        });
    }

    public function updatePersonal(Employee $employee, array $data): Employee
    {
        $personalService = app(PersonalTabService::class);
        return $personalService->updatePersonalDetails($employee, $data);
    }

    public function getFingerprintData(Employee $employee): array
    {
        $fingerprint = null;
        $locations = [];

        if (class_exists('\App\Models\FingerprintUser')) {
            $fingerprint = \App\Models\FingerprintUser::where('emp_id', $employee->emp_id)->first();
        }

        return [
            'employee'    => $employee,
            'fingerprint' => $fingerprint,
            'locations'   => $locations,
        ];
    }

    public function storeFingerprint(Employee $employee, array $data): void
    {
        DB::transaction(function () use ($employee, $data) {
            if (class_exists('\App\Models\FingerprintUser')) {
                \App\Models\FingerprintUser::updateOrCreate(
                    ['emp_id' => $employee->emp_id],
                    [
                        'name'     => $data['name'],
                        'cardno'   => $data['cardno'] ?? null,
                        'role'     => $data['role'],
                        'password' => isset($data['password']) && !empty($data['password']) ? Hash::make($data['password']) : null,
                        'location' => $data['location'],
                    ]
                );
            }
        });
    }

    public function getUserLoginData(Employee $employee): array
    {
        $user = User::where('emp_id', $employee->id)->orWhere('email', $employee->emp_id)->first();

        return [
            'employee' => $employee,
            'user'     => $user,
        ];
    }

    public function storeUserLogin(Employee $employee, array $data): User
    {
        return DB::transaction(function () use ($employee, $data) {
            $user = User::where('emp_id', $employee->id)->first();

            $userData = [
                'name'   => $employee->emp_name_with_initial,
                'email'  => $data['email'],
                'emp_id' => $employee->id,
            ];

            if (!empty($data['password'])) {
                $userData['password'] = Hash::make($data['password']);
            }

            if ($user) {
                $user->update($userData);
            } else {
                if (empty($userData['password'])) {
                    $userData['password'] = Hash::make('password123');
                }
                $user = User::create($userData);
            }

            return $user;
        });
    }

    public function resign(Employee $employee, string $date, ?string $remark = null): Employee
    {
        return DB::transaction(function () use ($employee, $date, $remark) {
            $updateData = [
                'is_resigned'      => 1,
                'modified_user_id' => auth()->id(),
            ];

            if (Schema::hasColumn('employees', 'resignation_date')) {
                $updateData['resignation_date'] = $date;
            }
            if (Schema::hasColumn('employees', 'resignation_remark')) {
                $updateData['resignation_remark'] = $remark;
            }

            $employee->update($updateData);

            return $employee;
        });
    }

    public function undoResign(Employee $employee): Employee
    {
        return DB::transaction(function () use ($employee) {
            $updateData = [
                'is_resigned'      => 0,
                'modified_user_id' => auth()->id(),
            ];

            if (Schema::hasColumn('employees', 'resignation_date')) {
                $updateData['resignation_date'] = null;
            }
            if (Schema::hasColumn('employees', 'resignation_remark')) {
                $updateData['resignation_remark'] = null;
            }

            $employee->update($updateData);

            return $employee;
        });
    }
}