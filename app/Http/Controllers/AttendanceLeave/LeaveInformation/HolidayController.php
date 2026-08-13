<?php

namespace App\Http\Controllers\AttendanceLeave\LeaveInformation;

use App\Http\Controllers\Controller;
use App\Models\AttendanceLeave\Holiday;
use App\Services\AttendanceLeave\LeaveInformation\HolidayService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class HolidayController extends Controller
{
    protected $service;

    public function __construct(HolidayService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->data($request);
        }

        return view('attendance_leave.leaveInformation.holidays');
    }

    public function data(Request $request)
    {
        $query = Holiday::query()->orderBy('date', 'desc');

        return DataTables::of($query)
            ->editColumn('holiday_type', function ($row) {
                $types = [
                    '1' => 'Poya Holiday',
                    '2' => 'Public & Bank Holiday',
                    '3' => 'Public, Bank & Mercantile Holiday',
                ];
                return $types[$row->holiday_type] ?? $row->holiday_type;
            })
            ->editColumn('work_level', function ($row) {
                $levels = [
                    '1' => 'Normal O.T.',
                    '2' => 'Double O.T.',
                ];
                return $levels[$row->work_level] ?? $row->work_level;
            })
            ->editColumn('date', function ($row) {
                return $row->date ? date('Y-m-d', strtotime($row->date)) : '-';
            })
            ->make(true);
    }

    protected function rules(): array
    {
        return [
            'holiday_name' => ['required', 'string', 'max:255'],
            'holiday_type' => ['required', 'string'],
            'half_short' => ['required', 'numeric'],
            'date' => ['required', 'string'],
            'work_level' => ['required', 'string'],
        ];
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        $holiday = $this->service->create($validated);

        return response()->json([
            'message' => 'Holiday created successfully',
            'data' => $holiday,
        ]);
    }

    public function edit(Holiday $holiday)
    {
        return response()->json([
            'id' => $holiday->id,
            'holiday_name' => $holiday->holiday_name,
            'holiday_type' => $holiday->holiday_type,
            'half_short' => $holiday->half_short,
            'date' => $holiday->date ? date('Y-m-d', strtotime($holiday->date)) : '',
            'work_level' => $holiday->work_level,
        ]);
    }

    public function update(Request $request, Holiday $holiday)
    {
        $validated = $request->validate($this->rules());

        $holiday = $this->service->update($holiday, $validated);

        return response()->json([
            'message' => 'Holiday updated successfully',
            'data' => $holiday,
        ]);
    }

    public function destroy(Holiday $holiday)
    {
        $this->service->delete($holiday);

        return response()->json([
            'message' => 'Holiday deleted successfully',
        ]);
    }
}
