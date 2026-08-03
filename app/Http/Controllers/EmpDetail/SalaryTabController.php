<?php

namespace App\Http\Controllers\EmpDetail;

use App\Http\Controllers\Controller;
use App\Models\EmpDetail\Employee;
use App\Models\EmpDetail\EmployeeSalary;
use App\Services\EmpDetail\SalaryTabService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SalaryTabController extends Controller
{
    protected $service;

    public function __construct(SalaryTabService $service)
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

        return view('employee_management.details.tab.salary', [
            'emp'       => $employee,
            'employee'  => $employee,
            'photo_url' => $photoUrl,
        ]);
    }

    public function data(Employee $employee)
    {
        $query = $this->service->getSalaryQuery($employee);

        return DataTables::of($query)
            ->addColumn('emp_sal_basic_salary', function ($row) {
                return number_format($row->emp_sal_basic_salary, 2);
            })
            ->addColumn('br_01', function ($row) {
                return number_format($row->br_01, 2);
            })
            ->addColumn('br_02', function ($row) {
                return number_format($row->br_02, 2);
            })
            ->addColumn('total', function ($row) {
                return number_format($row->total, 2);
            })
            ->make(true);
    }

    public function store(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'emp_sal_basic_salary' => ['required', 'numeric', 'min:0'],
            'br_01'                => ['nullable', 'numeric', 'min:0'],
            'br_02'                => ['nullable', 'numeric', 'min:0'],
            'total'                => ['nullable', 'numeric', 'min:0'],
        ]);

        $salary = $this->service->store($employee, $validated);

        return response()->json([
            'success' => true,
            'message' => 'Salary details added successfully',
            'data'    => $salary,
        ]);
    }

    public function edit(Employee $employee, EmployeeSalary $salary)
    {
        return response()->json([
            'success' => true,
            'data'    => [
                'id'                   => $salary->id,
                'emp_sal_basic_salary' => $salary->emp_sal_basic_salary,
                'br_01'                => $salary->br_01,
                'br_02'                => $salary->br_02,
                'total'                => $salary->total,
            ],
        ]);
    }

    public function update(Request $request, Employee $employee, EmployeeSalary $salary)
    {
        $validated = $request->validate([
            'emp_sal_basic_salary' => ['required', 'numeric', 'min:0'],
            'br_01'                => ['nullable', 'numeric', 'min:0'],
            'br_02'                => ['nullable', 'numeric', 'min:0'],
            'total'                => ['nullable', 'numeric', 'min:0'],
            'effective_date'       => ['nullable', 'date'],
        ]);

        $updatedSalary = $this->service->update($salary, $validated);

        return response()->json([
            'success' => true,
            'message' => 'Salary details updated successfully',
            'data'    => $updatedSalary,
        ]);
    }

    public function destroy(Employee $employee, EmployeeSalary $salary)
    {
        $this->service->delete($salary);

        return response()->json([
            'success' => true,
            'message' => 'Salary details deleted successfully',
        ]);
    }
}
