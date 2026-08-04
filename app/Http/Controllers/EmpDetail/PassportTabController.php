<?php

namespace App\Http\Controllers\EmpDetail;

use App\Http\Controllers\Controller;
use App\Models\EmpDetail\Employee;
use App\Models\EmpDetail\EmployeePassport;
use App\Services\EmpDetail\PassportTabService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PassportTabController extends Controller
{
    protected $service;

    public function __construct(PassportTabService $service)
    {
        $this->service = $service;
    }

    public function show(Employee $employee, Request $request)
    {
        $details = $this->service->getPassportDetails($employee);

        if ($request->wantsJson() && !$request->acceptsHtml()) {
            return response()->json([
                'success'   => true,
                'employee'  => $employee,
                'photo_url' => $details['photo_url'],
            ]);
        }

        return view('employee_management.details.tab.passport', [
            'emp'       => $employee,
            'employee'  => $employee,
            'photo_url' => $details['photo_url'],
        ]);
    }

    public function data(Employee $employee)
    {
        $query = $this->service->getPassportQuery($employee);

        return DataTables::of($query)
            ->addColumn('emp_pass_id', function ($row) {
                return $row->id;
            })
            ->make(true);
    }

    public function store(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'emp_pass_type'        => ['nullable', 'string', 'max:255'],
            'epf_no'               => ['required', 'string', 'max:255'],
            'emp_pass_issue_date'  => ['required', 'date'],
            'emp_pass_expire_date' => ['required', 'date'],
            'emp_pass_status'      => ['nullable', 'string', 'max:255'],
            'emp_pass_comments'    => ['nullable', 'string'],
            'emp_pass_review'      => ['nullable', 'string', 'max:255'],
        ]);

        $passport = $this->service->storePassport($employee, $validated);

        return response()->json([
            'success' => true,
            'message' => 'Passport details saved successfully',
            'data'    => $passport,
        ]);
    }

    public function edit(Employee $employee, EmployeePassport $passport)
    {
        return response()->json([
            'success' => true,
            'data'    => array_merge($passport->toArray(), ['emp_pass_id' => $passport->id]),
        ]);
    }

    public function update(Request $request, Employee $employee, EmployeePassport $passport)
    {
        $validated = $request->validate([
            'emp_pass_type'        => ['nullable', 'string', 'max:255'],
            'epf_no'               => ['required', 'string', 'max:255'],
            'emp_pass_issue_date'  => ['required', 'date'],
            'emp_pass_expire_date' => ['required', 'date'],
            'emp_pass_status'      => ['nullable', 'string', 'max:255'],
            'emp_pass_comments'    => ['nullable', 'string'],
            'emp_pass_review'      => ['nullable', 'string', 'max:255'],
        ]);

        $updatedPassport = $this->service->updatePassport($passport, $validated);

        return response()->json([
            'success' => true,
            'message' => 'Passport details updated successfully',
            'data'    => $updatedPassport,
        ]);
    }

    public function destroy(Employee $employee, EmployeePassport $passport)
    {
        $this->service->deletePassport($passport);

        return response()->json([
            'success' => true,
            'message' => 'Passport details deleted successfully',
        ]);
    }
}
