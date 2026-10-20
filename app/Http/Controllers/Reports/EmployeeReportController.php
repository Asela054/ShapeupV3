<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Models\Organization\Company;
use App\Models\Organization\Department;
use App\Services\Reports\EmployeeReportService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class EmployeeReportController extends Controller
{
    protected $service;

    public function __construct(EmployeeReportService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $companies = Company::orderBy('name')->get();
        $departments = Department::orderBy('name')->get();

        return view('Reports/employee_details_report/employee_report', compact('companies', 'departments'));
    }

    public function data(Request $request)
    {
        $query = $this->service->getEmployeeReportQuery([
            'company_id'    => $request->company_id,
            'department_id' => $request->department_id,
        ]);

        return DataTables::of($query)
            ->addColumn('employee', function ($row) {
                return $row->emp_name_with_initial ?: ($row->calling_name ?: '-');
            })
            ->addColumn('location', function ($row) {
                return $row->employmentDetail->location->location ?? ($row->employmentDetail->location->code ?? '-');
            })
            ->addColumn('department', function ($row) {
                return $row->employmentDetail->department->name ?? '-';
            })
            ->addColumn('dob', function ($row) {
                return $row->personalDetail->emp_birthday ?? '-';
            })
            ->addColumn('mobile', function ($row) {
                return $row->contactDetail->mobile_number ?? ($row->contactDetail->personal_number ?? '-');
            })
            ->addColumn('telephone', function ($row) {
                return $row->contactDetail->work_telephone ?? ($row->contactDetail->emp_home_no ?? '-');
            })
            ->addColumn('nic', function ($row) {
                return $row->personalDetail->emp_national_id ?? '-';
            })
            ->addColumn('gender', function ($row) {
                return $row->personalDetail->emp_gender ?? '-';
            })
            ->addColumn('email', function ($row) {
                return $row->contactDetail->emp_email ?? '-';
            })
            ->addColumn('permanent_address', function ($row) {
                return $row->contactDetail->emp_address ?? '-';
            })
            ->addColumn('temporary_address', function ($row) {
                return $row->contactDetail->emp_addressT1 ?? '-';
            })
            ->addColumn('job_category', function ($row) {
                return $row->employmentDetail->jobCategory->category ?? '-';
            })
            ->addColumn('job_status', function ($row) {
                return $row->employmentStatus->emp_status ?? ($row->is_resigned ? 'Resigned' : 'Active');
            })
            ->addColumn('permanent_date', function ($row) {
                return $row->employmentDetail->emp_permanent_date ?? '-';
            })
            ->filterColumn('employee', function ($query, $keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->where('emp_name_with_initial', 'like', "%{$keyword}%")
                      ->orWhere('calling_name', 'like', "%{$keyword}%");
                });
            })
            ->filterColumn('nic', function ($query, $keyword) {
                $query->whereHas('personalDetail', function ($q) use ($keyword) {
                    $q->where('emp_national_id', 'like', "%{$keyword}%");
                });
            })
            ->filterColumn('department', function ($query, $keyword) {
                $query->whereHas('employmentDetail.department', function ($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%");
                });
            })
            ->filterColumn('location', function ($query, $keyword) {
                $query->whereHas('employmentDetail.location', function ($q) use ($keyword) {
                    $q->where('location', 'like', "%{$keyword}%")
                      ->orWhere('code', 'like', "%{$keyword}%");
                });
            })
            ->filterColumn('mobile', function ($query, $keyword) {
                $query->whereHas('contactDetail', function ($q) use ($keyword) {
                    $q->where('mobile_number', 'like', "%{$keyword}%")
                      ->orWhere('personal_number', 'like', "%{$keyword}%");
                });
            })
            ->filterColumn('email', function ($query, $keyword) {
                $query->whereHas('contactDetail', function ($q) use ($keyword) {
                    $q->where('emp_email', 'like', "%{$keyword}%");
                });
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