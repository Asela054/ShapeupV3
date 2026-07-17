<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Models\Organization\JobCategory;
use App\Services\Organization\JobCategoryService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class JobCategoryController extends Controller
{
    protected $service;

    public function __construct(JobCategoryService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('organization.jobcategory');
    }

    public function data(Request $request)
    {
        $jobCategories = JobCategory::query();

        return DataTables::of($jobCategories)
            ->addColumn('morning_ot_applicable', function ($row) {
                return $row->morning_ot;
            })
            ->addColumn('lunch_hours_deduct', function ($row) {
                return $row->lunch_deduct_type;
            })
            ->addColumn('special_day_01_day', function ($row) {
                return $row->spe_day_1_day;
            })
            ->make(true);
    }

    protected function rules(): array
    {
        return [
            'category' => ['required', 'string', 'max:255'],
            'annual_leaves' => ['required', 'integer'],
            'casual_leaves' => ['required', 'integer'],
            'medical_leaves' => ['required', 'integer'],
            'normal_ot_rate' => ['nullable', 'numeric'],
            'double_ot_rate' => ['nullable', 'numeric'],
            'no_pay_rate_per_hour' => ['nullable', 'numeric'],
            'no_pay_rate_per_day' => ['nullable', 'numeric'],
            'saturday_rate' => ['nullable', 'numeric'],
            'sunday_rate' => ['nullable', 'numeric'],
            'emp_payroll_workdays' => ['required', 'integer'],
            'emp_payroll_workhrs' => ['required', 'numeric'],
            'is_sat_ot_type_as_act' => ['nullable', 'integer'],
            'custom_saturday_ot_type' => ['nullable', 'numeric'],
            'is_sun_ot_type_as_act' => ['nullable', 'integer'],
            'custom_sunday_ot_type' => ['nullable', 'numeric'],
            'sun_after_double' => ['nullable', 'numeric'],
            'spe_day_1_day' => ['nullable', 'string'],
            'spe_day_1_type' => ['nullable', 'integer'],
            'spe_day_1_rate' => ['nullable', 'numeric'],
            'ot_app_hours' => ['required', 'numeric'],
            'holiday_ot_minimum_min' => ['required', 'integer'],
            'holiday_ot_start' => ['nullable', 'integer'],
            'holiday_lunch_deduct' => ['nullable', 'integer'],
            'spe_deduct_pre' => ['required', 'numeric'],
            'lunch_deduct_type' => ['nullable', 'integer'],
            'lunch_deduct_min' => ['nullable', 'numeric'],
            'morning_ot' => ['nullable', 'integer'],
            'shift_hours' => ['required', 'numeric'],
            'work_hour_date' => ['nullable', 'string', 'max:45'],
            'late_attend_min' => ['nullable', 'integer'],
            'salary_without_attendace' => ['nullable', 'integer'],
            'holiday_work_hours' => ['required', 'numeric'],
            'late_type' => ['nullable', 'integer'],
            'short_leaves' => ['nullable', 'integer'],
            'half_days' => ['nullable', 'integer'],
            'week_after_double' => ['required', 'numeric'],
            'ot_round_time' => ['nullable', 'integer'],
            'flex_ot' => ['nullable'],
            'late_deduction_type' => ['nullable'],
            'basic_ot_type' => ['nullable', 'string'],
            'custom_normal_ot_rate' => ['nullable', 'numeric'],
            'custom_double_ot_rate' => ['nullable', 'numeric'],
            'salary_advance_type' => ['nullable', 'string'],
            'salary_advance_value' => ['nullable', 'numeric'],
            'salary_advance_min_date' => ['nullable'],
            'late_deduct_calculation' => ['nullable', 'string'],
            'full_day_work_hours' => ['nullable', 'numeric'],
            'status' => ['nullable', 'integer'],
        ];
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        $jobCategory = $this->service->create($validated);

        return response()->json(['message' => 'Job category created successfully', 'data' => $jobCategory]);
    }

    public function edit(JobCategory $jobCategory)
    {
        return response()->json($jobCategory);
    }

    public function update(Request $request, JobCategory $jobCategory)
    {
        $validated = $request->validate($this->rules());

        $jobCategory = $this->service->update($jobCategory, $validated);

        return response()->json(['message' => 'Job category updated successfully', 'data' => $jobCategory]);
    }

    public function destroy(JobCategory $jobCategory)
    {
        $this->service->delete($jobCategory);

        return response()->json(['message' => 'Job category deleted successfully']);
    }
}