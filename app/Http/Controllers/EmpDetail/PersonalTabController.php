<?php

namespace App\Http\Controllers\EmpDetail;

use App\Http\Controllers\Controller;
use App\Models\EmpDetail\Employee;
use App\Services\EmpDetail\PersonalTabService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PersonalTabController extends Controller
{
    protected $service;

    public function __construct(PersonalTabService $service)
    {
        $this->service = $service;
    }

    public function show(Employee $employee, Request $request)
    {
        $details = $this->service->getPersonalDetails($employee);

        if ($request->wantsJson() || $request->ajax() && !$request->acceptsHtml()) {
            return response()->json([
                'success' => true,
                'data'    => $details,
            ]);
        }

        return view('employee_management.details.tab.personal', [
            'emp'       => $employee,
            'employee'  => $employee,
            'photo_url' => $details['photo_url'],
        ]);
    }

    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            // Personal Info
            'emp_first_name'        => ['nullable', 'string', 'max:255'],
            'emp_med_name'          => ['nullable', 'string', 'max:255'],
            'emp_last_name'         => ['nullable', 'string', 'max:255'],
            'emp_name_with_initial' => ['nullable', 'string', 'max:255'],
            'calling_name'          => ['nullable', 'string', 'max:255'],
            'emp_national_id'       => ['nullable', 'string', 'max:255'],
            'emp_fullname'          => ['nullable', 'string', 'max:450'],

            // Contact Info
            'emp_address'           => ['nullable', 'string', 'max:500'],
            'emp_addressT1'         => ['nullable', 'string', 'max:500'],
            'emp_email'             => ['nullable', 'email', 'max:255'],
            'emp_other_email'       => ['nullable', 'email', 'max:255'],
            'emp_con_mobile'        => ['nullable', 'string', 'max:50'],
            'emp_mobile'            => ['nullable', 'string', 'max:50'],
            'emp_work_telephone'    => ['nullable', 'string', 'max:50'],
            'photograph'            => ['nullable', 'image', 'max:2048'],

            // Other Info
            'emp_gender'            => ['nullable', 'string', 'max:20'],
            'emp_marital_status'    => ['nullable', 'string', 'max:50'],
            'emp_nationality'       => ['nullable', 'string', 'max:100'],
            'emp_birthday'          => ['nullable', 'date'],

            // Work Info
            'emp_etfno'             => ['nullable', 'string', 'max:150'],
            'emp_id'                => ['nullable'],
            'emp_drive_license'     => ['nullable', 'string', 'max:100'],
            'emp_license_expire_date' => ['nullable', 'date'],
            'emp_assign_date'       => ['nullable', 'date'],
            'emp_join_date'         => ['nullable', 'date'],
            'emp_job_code'          => ['nullable'],
            'emp_status'            => ['nullable'],
            'hierarchy_id'          => ['nullable'],
            'financial_id'          => ['nullable'],
            'leave_approve_person'  => ['nullable'],

            // Location Info
            'emp_company'           => ['nullable'],
            'emp_location'          => ['nullable'],
            'emp_department'        => ['nullable'],
            'emp_shift'             => ['nullable'],
            'work_category_id'      => ['nullable'],

            // Additional Info
            'ds_divition'           => ['nullable'],
            'gsn_divition'          => ['nullable'],
            'gsn_name'              => ['nullable', 'string', 'max:255'],
            'gsn_contactno'         => ['nullable', 'string', 'max:50'],
            'police_station'        => ['nullable'],
            'police_contactno'      => ['nullable', 'string', 'max:50'],
        ]);

        $updatedEmployee = $this->service->updatePersonalDetails(
            $employee,
            $validated,
            $request->file('photograph')
        );

        return response()->json([
            'success' => true,
            'message' => 'Personal details updated successfully',
            'data'    => $updatedEmployee,
        ]);
    }
}
