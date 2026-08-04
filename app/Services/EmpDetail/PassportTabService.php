<?php

namespace App\Services\EmpDetail;

use App\Models\EmpDetail\Employee;
use App\Models\EmpDetail\EmployeePassport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PassportTabService
{
    public function getPassportDetails(Employee $employee): array
    {
        $photoUrl = null;
        if (isset($employee->photograph) && $employee->photograph) {
            $photoUrl = asset('storage/' . $employee->photograph);
        }

        return [
            'photo_url' => $photoUrl,
        ];
    }

    public function getPassportQuery(Employee $employee)
    {
        return EmployeePassport::where('emp_id', $employee->id)->orderByDesc('id');
    }

    public function storePassport(Employee $employee, array $data): EmployeePassport
    {
        return EmployeePassport::create(array_merge($data, [
            'emp_id' => $employee->id,
        ]));
    }

    public function updatePassport(EmployeePassport $passport, array $data): EmployeePassport
    {
        $passport->update($data);
        return $passport;
    }

    public function deletePassport(EmployeePassport $passport): void
    {
        $passport->delete();
    }
}
