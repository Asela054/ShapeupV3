<?php

namespace App\Http\Controllers\EmpDetail;

use App\Http\Controllers\Controller;
use App\Models\EmpDetail\Employee;
use App\Models\EmpDetail\EmployeeEmergencyContact;
use App\Services\EmpDetail\EmergencyContactTabService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class EmergencyContactTabController extends Controller
{
    protected $service;

    public function __construct(EmergencyContactTabService $service)
    {
        $this->service = $service;
    }

    public function show(Employee $employee, Request $request)
    {
        $photoUrl = isset($employee->photograph) && $employee->photograph ? asset('storage/' . $employee->photograph) : null;

        if ($request->wantsJson() && !$request->acceptsHtml()) {
            return response()->json([
                'success'   => true,
                'employee'  => $employee,
                'photo_url' => $photoUrl,
            ]);
        }

        return view('employee_management.details.tab.emergency-contacts', [
            'emp'       => $employee,
            'employee'  => $employee,
            'photo_url' => $photoUrl,
        ]);
    }

    public function data(Employee $employee)
    {
        $query = $this->service->getEmergencyContactsQuery($employee);

        return DataTables::of($query)
            ->addColumn('name', function ($row) {
                return $row->person_name;
            })
            ->addColumn('relationship', function ($row) {
                return $row->relationship;
            })
            ->addColumn('address', function ($row) {
                return $row->address ?: '-';
            })
            ->addColumn('contact_no', function ($row) {
                return $row->contact_number ?: '-';
            })
            ->make(true);
    }

    public function store(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'name'         => ['nullable', 'string', 'max:200'],
            'person_name'  => ['nullable', 'string', 'max:200'],
            'relationship' => ['required', 'string', 'max:100'],
            'contact_no'   => ['nullable', 'string', 'max:20'],
            'contact_number' => ['nullable', 'string', 'max:20'],
            'address'      => ['nullable', 'string', 'max:200'],
        ]);

        $contact = $this->service->store($employee, $validated);

        return response()->json([
            'success' => true,
            'message' => 'Emergency contact added successfully',
            'data'    => $contact,
        ]);
    }

    public function edit(Employee $employee, EmployeeEmergencyContact $contact)
    {
        return response()->json([
            'success' => true,
            'data'    => [
                'id'           => $contact->id,
                'name'         => $contact->person_name,
                'person_name'  => $contact->person_name,
                'relationship' => $contact->relationship,
                'address'      => $contact->address,
                'contact_no'   => $contact->contact_number,
                'contact_number' => $contact->contact_number,
            ],
        ]);
    }

    public function update(Request $request, Employee $employee, EmployeeEmergencyContact $contact)
    {
        $validated = $request->validate([
            'name'         => ['nullable', 'string', 'max:200'],
            'person_name'  => ['nullable', 'string', 'max:200'],
            'relationship' => ['required', 'string', 'max:100'],
            'contact_no'   => ['nullable', 'string', 'max:20'],
            'contact_number' => ['nullable', 'string', 'max:20'],
            'address'      => ['nullable', 'string', 'max:200'],
        ]);

        $updatedContact = $this->service->update($contact, $validated);

        return response()->json([
            'success' => true,
            'message' => 'Emergency contact updated successfully',
            'data'    => $updatedContact,
        ]);
    }

    public function destroy(Employee $employee, EmployeeEmergencyContact $contact)
    {
        $this->service->delete($contact);

        return response()->json([
            'success' => true,
            'message' => 'Emergency contact deleted successfully',
        ]);
    }
}
