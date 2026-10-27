<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Models\Organization\Department;
use App\Services\Reports\EmployeeResignReportService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EmployeeResignReportController extends Controller
{
    protected $service;

    public function __construct(EmployeeResignReportService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $departments = Department::orderBy('name')->get();

        return view('Reports/employee_details_report/employee_resign_report', compact('departments'));
    }

    public function data(Request $request)
    {
        $request->validate([
            'department_id' => 'required',
        ]);

        $records = $this->service->getEmployeeResignReportQuery([
            'department_id' => $request->department_id,
            'from_date'     => $request->from_date,
            'to_date'       => $request->to_date,
        ])->get();

        $data = $records->map(function ($row) {
            $employee   = $row->employee;
            $personal   = $employee?->personalDetail;
            $contact    = $employee?->contactDetail;
            $employment = $employee?->employmentDetail;

            // Calculate work days from join date to resignation date
            $workDaysCount = '-';
            if ($employment?->emp_join_date && $row->resignation_date) {
                $joinDate        = Carbon::parse($employment->emp_join_date);
                $resignationDate = Carbon::parse($row->resignation_date);
                $workDaysCount   = $joinDate->diffInDays($resignationDate);
            }

            return [
                'employee_id'       => $employee?->emp_id ?? '-',
                'employee'          => $employee?->emp_name_with_initial ?: ($employee?->calling_name ?? '-'),
                'location'          => $employment?->location?->location ?? ($employment?->location?->code ?? '-'),
                'department'        => $employment?->department?->name ?? '-',
                'dob'               => $personal?->emp_birthday ?? '-',
                'mobile_no'         => $contact?->mobile_number ?? ($contact?->personal_number ?? '-'),
                'nic'               => $personal?->emp_national_id ?? '-',
                'gender'            => $personal?->emp_gender ?? '-',
                'permanent_address' => $contact?->emp_address ?? '-',
                'job_category'      => $employment?->jobCategory?->name ?? '-',
                'permanent_date'    => $employment?->emp_permanent_date ?? '-',
                'resignation_date'  => $row->resignation_date ?? '-',
                'work_days_count'   => $workDaysCount,
            ];
        });

        return response()->json(['data' => $data]);
    }

    public function getDepartments(Request $request)
    {
        $query = Department::select('id', 'name')->orderBy('name');

        return response()->json($query->get());
    }
}
