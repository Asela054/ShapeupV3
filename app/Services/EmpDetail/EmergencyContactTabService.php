<?php

namespace App\Services\EmpDetail;

use App\Models\EmpDetail\Employee;
use App\Models\EmpDetail\EmployeeEmergencyContact;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EmergencyContactTabService
{
    public function getEmergencyContactsQuery(Employee $employee)
    {
        return EmployeeEmergencyContact::query()->where('emp_id', $employee->id);
    }

    public function store(Employee $employee, array $data): EmployeeEmergencyContact
    {
        return DB::transaction(function () use ($employee, $data) {
            return EmployeeEmergencyContact::create([
                'emp_id'         => $employee->id,
                'person_name'    => $data['person_name'] ?? ($data['name'] ?? null),
                'relationship'   => $data['relationship'] ?? null,
                'address'        => $data['address'] ?? null,
                'contact_number' => $data['contact_number'] ?? ($data['contact_no'] ?? null),
            ]);
        });
    }

    public function find(int $id): ?EmployeeEmergencyContact
    {
        return EmployeeEmergencyContact::find($id);
    }

    public function update(EmployeeEmergencyContact $contact, array $data): EmployeeEmergencyContact
    {
        return DB::transaction(function () use ($contact, $data) {
            $contact->update([
                'person_name'    => $data['person_name'] ?? ($data['name'] ?? $contact->person_name),
                'relationship'   => $data['relationship'] ?? $contact->relationship,
                'address'        => $data['address'] ?? $contact->address,
                'contact_number' => $data['contact_number'] ?? ($data['contact_no'] ?? $contact->contact_number),
            ]);

            return $contact->fresh();
        });
    }

    public function delete(EmployeeEmergencyContact $contact): ?bool
    {
        return DB::transaction(function () use ($contact) {
            return $contact->delete();
        });
    }
}
