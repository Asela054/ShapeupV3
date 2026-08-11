<?php

namespace App\Http\Controllers\ShiftManagement;

use App\Http\Controllers\Controller;
use App\Models\ShiftManagement\ShiftType;
use App\Services\ShiftManagement\WorkShiftService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class WorkShiftController extends Controller
{
    protected $service;

    public function __construct(WorkShiftService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('shift_management.work_shifts');
    }

    public function data(Request $request)
    {
        $query = ShiftType::query();

        return DataTables::of($query)
            ->addColumn('offduty_date', function ($row) {
                return ($row->offduty_day == 1 || $row->offduty_day === 'next_day') ? 'Next day' : 'Today';
            })
            ->make(true);
    }

    protected function rules(?int $id = null): array
    {
        return [
            'shift_name' => ['required', 'string', 'max:255'],
            'shift_code' => ['required', 'string', 'max:20'],
            'onduty_time' => ['required', 'string', 'max:255'],
            'offduty_time' => ['required', 'string', 'max:255'],
            'saturday_onduty_time' => ['required', 'string'],
            'saturday_offduty_time' => ['required', 'string'],
            'late_grace_time' => ['nullable', 'string', 'max:255'],
            'late_time' => ['nullable', 'string', 'max:255'],
            'leave_early_time' => ['required', 'string', 'max:255'],
            'begining_checkin' => ['required', 'string', 'max:255'],
            'begining_checkout' => ['required', 'string', 'max:255'],
            'workdays_count' => ['required', 'numeric'],
            'minute_count' => ['required', 'numeric'],
            'weekly_max_normal_ot' => ['nullable', 'numeric'],
            'weekly_max_double_ot' => ['nullable', 'numeric'],
            'weekend_max_normal_ot' => ['nullable', 'numeric'],
            'weekend_max_double_ot' => ['nullable', 'numeric'],
            'actual_ot_calculation' => ['nullable', 'integer'],
            'off_duty_day' => ['nullable', 'string'],
            'off_next_day' => ['nullable', 'integer'],
            'on_next_day' => ['nullable', 'integer'],
        ];
    }

    protected function mapInputToAttributes(array $validated): array
    {
        return [
            'shift_name' => $validated['shift_name'],
            'shift_code' => $validated['shift_code'],
            'onduty_time' => $validated['onduty_time'],
            'offduty_time' => $validated['offduty_time'],
            'saturday_onduty_time' => $validated['saturday_onduty_time'],
            'saturday_offduty_time' => $validated['saturday_offduty_time'],
            'late_time' => $validated['late_grace_time'] ?? $validated['late_time'] ?? '00:00',
            'leave_early_time' => $validated['leave_early_time'],
            'begining_checkin' => $validated['begining_checkin'],
            'begining_checkout' => $validated['begining_checkout'],
            'workdays_count' => (string) $validated['workdays_count'],
            'minute_count' => (string) $validated['minute_count'],
            'max_normal_ot_hrs' => $validated['weekly_max_normal_ot'] ?? null,
            'max_double_ot_hrs' => $validated['weekly_max_double_ot'] ?? null,
            'weekend_max_normal_ot_hrs' => $validated['weekend_max_normal_ot'] ?? null,
            'weekend_max_double_ot_hrs' => $validated['weekend_max_double_ot'] ?? null,
            'ot_calculate_type' => $validated['actual_ot_calculation'] ?? 1,
            'offduty_day' => (isset($validated['off_duty_day']) && $validated['off_duty_day'] === 'next_day') ? 1 : 0,
            'off_next_day' => $validated['off_next_day'] ?? 0,
            'on_next_day' => $validated['on_next_day'] ?? 0,
            'status' => 1,
            'deleted' => 0,
        ];
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());
        $data = $this->mapInputToAttributes($validated);

        $workShift = $this->service->create($data);

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Work shift created successfully', 'data' => $workShift]);
        }

        return redirect()->back()->with('success', 'Work shift created successfully');
    }

    public function edit(ShiftType $workShift)
    {
        return response()->json([
            'id' => $workShift->id,
            'shift_name' => $workShift->shift_name,
            'shift_code' => $workShift->shift_code,
            'onduty_time' => $workShift->onduty_time,
            'offduty_time' => $workShift->offduty_time,
            'saturday_onduty_time' => $workShift->saturday_onduty_time,
            'saturday_offduty_time' => $workShift->saturday_offduty_time,
            'late_grace_time' => $workShift->late_time,
            'leave_early_time' => $workShift->leave_early_time,
            'begining_checkin' => $workShift->begining_checkin,
            'begining_checkout' => $workShift->begining_checkout,
            'workdays_count' => $workShift->workdays_count,
            'minute_count' => $workShift->minute_count,
            'weekly_max_normal_ot' => $workShift->max_normal_ot_hrs,
            'weekly_max_double_ot' => $workShift->max_double_ot_hrs,
            'weekend_max_normal_ot' => $workShift->weekend_max_normal_ot_hrs,
            'weekend_max_double_ot' => $workShift->weekend_max_double_ot_hrs,
            'actual_ot_calculation' => $workShift->ot_calculate_type ?? 1,
            'off_duty_day' => ($workShift->offduty_day == 1) ? 'next_day' : 'today',
            'off_next_day' => $workShift->off_next_day ?? 0,
            'on_next_day' => $workShift->on_next_day ?? 0,
        ]);
    }

    public function update(Request $request, ShiftType $workShift)
    {
        $validated = $request->validate($this->rules($workShift->id));
        $data = $this->mapInputToAttributes($validated);

        $updatedShift = $this->service->update($workShift, $data);

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Work shift updated successfully', 'data' => $updatedShift]);
        }

        return redirect()->back()->with('success', 'Work shift updated successfully');
    }

    public function destroy(ShiftType $workShift)
    {
        $this->service->delete($workShift);

        return response()->json(['message' => 'Work shift deleted successfully']);
    }
}
