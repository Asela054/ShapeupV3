<?php

namespace App\Http\Controllers\EmpDetail;

use App\Http\Controllers\Controller;
use App\Models\EmpDetail\Employee;
use App\Models\EmpDetail\EmployeeBank;
use App\Services\EmpDetail\BankTabService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BankTabController extends Controller
{
    protected $service;

    public function __construct(BankTabService $service)
    {
        $this->service = $service;
    }

    public function show(Employee $employee, Request $request)
    {
        $details = $this->service->getBankDetails($employee);

        if ($request->wantsJson() || ($request->ajax() && !$request->acceptsHtml())) {
            return response()->json([
                'success'   => true,
                'employee'  => $employee,
                'photo_url' => $details['photo_url'],
                'banks'     => $details['banks'],
                'branches'  => $details['branches'],
            ]);
        }

        return view('employee_management.details.tab.bank', [
            'emp'       => $employee,
            'employee'  => $employee,
            'photo_url' => $details['photo_url'],
            'banks'     => $details['banks'],
            'branches'  => $details['branches'],
        ]);
    }

    public function data(Employee $employee)
    {
        $query = $this->service->getBankQuery($employee);

        return DataTables::of($query)
            ->addColumn('bank_name', function ($row) {
                if (isset($row->bank) && isset($row->bank->name)) {
                    return $row->bank->name;
                }
                return $row->bank_code ?: '-';
            })
            ->addColumn('branch_name', function ($row) {
                if (isset($row->branch) && isset($row->branch->branch_name)) {
                    return $row->branch->branch_name;
                }
                return $row->branch_code ?: '-';
            })
            ->addColumn('status', function ($row) {
                return $row->status
                    ? '<span class="badge badge-light-success fw-bold">Active</span>'
                    : '<span class="badge badge-light-danger">Inactive</span>';
            })
            ->rawColumns(['status'])
            ->make(true);
    }

    public function store(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'bank_code'   => ['required', 'string', 'max:100'],
            'branch_code' => ['required', 'string', 'max:100'],
            'bank_ac_no'  => ['required', 'string', 'max:100'],
            'status'      => ['nullable', 'integer'],
        ]);

        $bank = $this->service->storeBank($employee, $validated);

        return response()->json([
            'success' => true,
            'message' => 'Bank details saved successfully',
            'data'    => $bank,
        ]);
    }

    public function edit(Employee $employee, EmployeeBank $bank)
    {
        return response()->json([
            'success' => true,
            'data'    => $bank,
        ]);
    }

    public function update(Request $request, Employee $employee, EmployeeBank $bank)
    {
        $validated = $request->validate([
            'bank_code'   => ['required', 'string', 'max:100'],
            'branch_code' => ['required', 'string', 'max:100'],
            'bank_ac_no'  => ['required', 'string', 'max:100'],
            'status'      => ['nullable', 'integer'],
        ]);

        $updatedBank = $this->service->updateBank($bank, $validated);

        return response()->json([
            'success' => true,
            'message' => 'Bank details updated successfully',
            'data'    => $updatedBank,
        ]);
    }

    public function destroy(Employee $employee, EmployeeBank $bank)
    {
        $this->service->deleteBank($bank);

        return response()->json([
            'success' => true,
            'message' => 'Bank details deleted successfully',
        ]);
    }
}
