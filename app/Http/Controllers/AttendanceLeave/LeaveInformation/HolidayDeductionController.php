<?php

namespace App\Http\Controllers\AttendanceLeave\LeaveInformation;

use App\Http\Controllers\Controller;
use App\Models\AttendanceLeave\HolidayDeduction;
use App\Models\Organization\JobCategory;
//use App\Models\Organization\Remuneration;
use App\Services\AttendanceLeave\LeaveInformation\HolidayDeductionService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class HolidayDeductionController extends Controller
{
    protected $service;

    public function __construct(HolidayDeductionService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->data($request);
        }

        $jobCategories = JobCategory::all();
        //$remunerations = Remuneration::all();

        return view('attendance_leave.leaveInformation.holiday_deduction', compact('jobCategories')); //'remunerations'
    }

    public function data(Request $request)
    {
        $deductions = HolidayDeduction::with(['jobCategory', 'remuneration']);

        return DataTables::of($deductions)
            ->addColumn('jobCategory', fn ($row) => $row->jobCategory->category ?? '-')
            ->addColumn('remunitionName', fn ($row) => $row->remuneration->remuneration_name ?? '-')
            ->addColumn('dayCount', fn ($row) => $row->day_count)
            ->addColumn('amount', fn ($row) => number_format($row->amount, 2))
            ->make(true);
    }

    protected function rules(?int $id = null): array
    {
        return [
            'jobCategory_id' => ['required', 'integer'],
            'remuneration_id' => ['required', 'integer'],
            'day' => ['required', 'numeric'],
            'amount' => ['nullable', 'numeric'],
        ];
    }

    protected function mapPayload(array $data): array
    {
        return [
            'job_id' => $data['jobCategory_id'],
            'remuneration_id' => $data['remuneration_id'],
            'day_count' => $data['day'],
            'amount' => $data['amount'] ?? 0,
        ];
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        $holidayDeduction = $this->service->create($this->mapPayload($validated));

        return response()->json(['message' => 'Holiday deduction created successfully', 'data' => $holidayDeduction]);
    }

    public function edit(HolidayDeduction $holidayDeduction)
    {
        $data = $holidayDeduction->toArray();
        $data['jobCategory_id'] = $holidayDeduction->job_id;
        $data['dayCount'] = $holidayDeduction->day_count;

        return response()->json($data);
    }

    public function update(Request $request, HolidayDeduction $holidayDeduction)
    {
        $validated = $request->validate($this->rules($holidayDeduction->id));

        $holidayDeduction = $this->service->update($holidayDeduction, $this->mapPayload($validated));

        return response()->json(['message' => 'Holiday deduction updated successfully', 'data' => $holidayDeduction]);
    }

    public function destroy(HolidayDeduction $holidayDeduction)
    {
        $this->service->delete($holidayDeduction);

        return response()->json(['message' => 'Holiday deduction deleted successfully']);
    }
}
