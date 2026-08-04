<?php

namespace App\Http\Controllers\EmpDetail;

use App\Http\Controllers\Controller;
use App\Models\EmpDetail\Employee;
use App\Models\EmpDetail\EmployeeDependentDetail;
use App\Services\EmpDetail\DependentTabService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DependentTabController extends Controller
{
    protected $service;

    public function __construct(DependentTabService $service)
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

        return view('employee_management.details.tab.dependents', [
            'emp'       => $employee,
            'employee'  => $employee,
            'photo_url' => $photoUrl,
        ]);
    }

    public function data(Employee $employee)
    {
        $query = $this->service->getDependentsQuery($employee);

        return DataTables::of($query)
            ->addColumn('emp_dep_name', function ($row) {
                return $row->emp_dep_name;
            })
            ->addColumn('emp_dep_relation', function ($row) {
                return $row->emp_dep_relation;
            })
            ->addColumn('emp_dep_birthday', function ($row) {
                return $row->emp_dep_birthday ?: '-';
            })
            ->make(true);
    }

    public function store(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'name'             => ['nullable', 'string', 'max:255'],
            'emp_dep_name'     => ['nullable', 'string', 'max:255'],
            'relation'         => ['nullable', 'string', 'max:100'],
            'emp_dep_relation' => ['required', 'string', 'max:100'],
            'birthday'         => ['nullable', 'date'],
            'emp_dep_birthday' => ['nullable', 'date'],
        ]);

        $dependent = $this->service->store($employee, $validated);

        return response()->json([
            'success' => true,
            'message' => 'Dependent details added successfully',
            'data'    => $dependent,
        ]);
    }

    public function edit(Employee $employee, EmployeeDependentDetail $dependent)
    {
        return response()->json([
            'success' => true,
            'data'    => [
                'id'               => $dependent->id,
                'emp_dep_name'     => $dependent->emp_dep_name,
                'name'             => $dependent->emp_dep_name,
                'emp_dep_relation' => $dependent->emp_dep_relation,
                'relation'         => $dependent->emp_dep_relation,
                'emp_dep_birthday' => $dependent->emp_dep_birthday,
                'birthday'         => $dependent->emp_dep_birthday,
            ],
        ]);
    }

    public function update(Request $request, Employee $employee, EmployeeDependentDetail $dependent)
    {
        $validated = $request->validate([
            'name'             => ['nullable', 'string', 'max:255'],
            'emp_dep_name'     => ['nullable', 'string', 'max:255'],
            'relation'         => ['nullable', 'string', 'max:100'],
            'emp_dep_relation' => ['required', 'string', 'max:100'],
            'birthday'         => ['nullable', 'date'],
            'emp_dep_birthday' => ['nullable', 'date'],
        ]);

        $updatedDependent = $this->service->update($dependent, $validated);

        return response()->json([
            'success' => true,
            'message' => 'Dependent details updated successfully',
            'data'    => $updatedDependent,
        ]);
    }

    public function destroy(Employee $employee, EmployeeDependentDetail $dependent)
    {
        $this->service->delete($dependent);

        return response()->json([
            'success' => true,
            'message' => 'Dependent details deleted successfully',
        ]);
    }
}
