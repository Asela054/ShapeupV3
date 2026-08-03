<?php

namespace App\Services\EmpDetail;

use App\Models\EmpDetail\Employee;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class PersonalTabService
{
    public function getPersonalDetails(Employee $employee): array
    {
        $photoUrl = null;
        if (isset($employee->photograph) && $employee->photograph) {
            $photoUrl = asset('storage/' . $employee->photograph);
        }

        return [
            'employee'  => $employee,
            'photo_url' => $photoUrl,
        ];
    }

    public function updatePersonalDetails(Employee $employee, array $data, $photograph = null): Employee
    {
        return DB::transaction(function () use ($employee, $data, $photograph) {
            // Handle photograph upload if provided
            if ($photograph) {
                if (isset($employee->photograph) && $employee->photograph) {
                    Storage::disk('public')->delete($employee->photograph);
                }
                $photoPath = $photograph->store('employee-photos', 'public');
                if (Schema::hasColumn('employees', 'photograph')) {
                    $data['photograph'] = $photoPath;
                }
            }

            // Map input field names to database column names 
            if (isset($data['emp_etfno'])) {
                $data['emp_etf_no'] = $data['emp_etfno'];
            }

            // Always add audit user ID
            $data['modified_user_id'] = auth()->id();

            // Filter data to only include existing columns in the employees table
            $updateData = [];
            foreach ($data as $key => $value) {
                if (Schema::hasColumn('employees', $key)) {
                    $updateData[$key] = $value;
                }
            }

            if (!empty($updateData)) {
                $employee->update($updateData);
            }

            return $employee->fresh();
        });
    }
}
