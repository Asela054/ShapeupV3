<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Models\Organization\Bank;
use App\Models\Organization\BankBranch;
use App\Models\Organization\Company;
use App\Models\Organization\Department;
use App\Services\Reports\EmployeeBankReportService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class EmployeeBankReportController extends Controller
{
    protected $service;

    public function __construct(EmployeeBankReportService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $companies = Company::orderBy('name')->get();
        $departments = Department::orderBy('name')->get();
        $banks = Bank::orderBy('name')->get();

        return view('Reports/employee_details_report/employee_bank_report', compact('companies', 'departments', 'banks'));
    }

    public function data(Request $request)
    {
        $query = $this->service->getEmployeeBankReportQuery([
            'company_id'    => $request->company_id,
            'department_id' => $request->department_id,
            'bank_id'       => $request->bank_id,
        ]);

        return DataTables::of($query)
            ->addColumn('employee_id', function ($row) {
                return $row->employee->emp_id ?? '-';
            })
            ->addColumn('employee', function ($row) {
                if (!$row->employee) {
                    return '-';
                }
                return $row->employee->emp_name_with_initial ?: ($row->employee->calling_name ?: '-');
            })
            ->addColumn('office', function ($row) {
                return $row->employee->employmentDetail->location->location
                    ?? ($row->employee->employmentDetail->location->code ?? '-');
            })
            ->addColumn('department', function ($row) {
                return $row->employee->employmentDetail->department->name ?? '-';
            })
            ->addColumn('bank', function ($row) {
                return $row->bank->name ?? ($row->bank_code ?: '-');
            })
            ->addColumn('branch', function ($row) {
                if (isset($row->branch) && isset($row->branch->branch_name) && $row->branch->bank_code == $row->bank_code) {
                    return $row->branch->branch_name;
                }
                $branch = BankBranch::where('bank_code', $row->bank_code)
                    ->where('code', $row->branch_code)
                    ->first();

                return $branch->branch_name ?? ($row->branch_code ?: '-');
            })
            ->addColumn('account_no', function ($row) {
                return $row->bank_ac_no ?? '-';
            })
            ->addColumn('employee_pk', function ($row) {
                return $row->employee->id ?? $row->emp_id;
            })
            ->filterColumn('employee_id', function ($query, $keyword) {
                $query->whereHas('employee', function ($q) use ($keyword) {
                    $q->where('emp_id', 'like', "%{$keyword}%");
                });
            })
            ->filterColumn('employee', function ($query, $keyword) {
                $query->whereHas('employee', function ($q) use ($keyword) {
                    $q->where('emp_name_with_initial', 'like', "%{$keyword}%")
                      ->orWhere('calling_name', 'like', "%{$keyword}%");
                });
            })
            ->filterColumn('office', function ($query, $keyword) {
                $query->whereHas('employee.employmentDetail.location', function ($q) use ($keyword) {
                    $q->where('location', 'like', "%{$keyword}%")
                      ->orWhere('code', 'like', "%{$keyword}%");
                });
            })
            ->filterColumn('department', function ($query, $keyword) {
                $query->whereHas('employee.employmentDetail.department', function ($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%");
                });
            })
            ->filterColumn('bank', function ($query, $keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->where('bank_code', 'like', "%{$keyword}%")
                      ->orWhereHas('bank', function ($bq) use ($keyword) {
                          $bq->where('name', 'like', "%{$keyword}%");
                      });
                });
            })
            ->filterColumn('branch', function ($query, $keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->where('branch_code', 'like', "%{$keyword}%")
                      ->orWhereHas('branch', function ($bq) use ($keyword) {
                          $bq->where('branch_name', 'like', "%{$keyword}%");
                      });
                });
            })
            ->filterColumn('account_no', function ($query, $keyword) {
                $query->where('bank_ac_no', 'like', "%{$keyword}%");
            })
            ->make(true);
    }

    public function getDepartments(Request $request)
    {
        $query = Department::select('id', 'name', 'company_id')->orderBy('name');

        if ($request->filled('company_id')) {
            $query->where('company_id', $request->company_id);
        }

        return response()->json($query->get());
    }
}
