<?php

namespace App\Http\Controllers\AttendanceLeave\LeaveInformation;

use App\Http\Controllers\Controller;
use App\Models\AttendanceLeave\IgnoreDay;
use App\Services\AttendanceLeave\LeaveInformation\IgnoreDayService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class IgnoreDayController extends Controller
{
    protected $service;

    public function __construct(IgnoreDayService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->data($request);
        }

        return view('attendance_leave.leaveInformation.ignore_days');
    }

    public function data(Request $request)
    {
        $query = IgnoreDay::query()->orderBy('date', 'desc');

        if ($request->filled('month')) {
            $month = $request->month;
            if (strlen($month) === 7) {
                $query->where('month', 'like', $month . '%');
            }
        }

        return DataTables::of($query)
            ->editColumn('month', function ($row) {
                return $row->month ? date('Y-m', strtotime($row->month)) : '-';
            })
            ->editColumn('date', function ($row) {
                return $row->date ? date('Y-m-d', strtotime($row->date)) : '-';
            })
            ->make(true);
    }

    protected function rules(): array
    {
        return [
            'month' => ['required', 'string'],
            'dates' => ['required', 'string'],
        ];
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        $result = $this->service->create($validated);

        return response()->json([
            'message' => 'Ignore days saved successfully',
            'data' => $result,
        ]);
    }

    public function edit(IgnoreDay $ignoreDay)
    {
        return response()->json([
            'id' => $ignoreDay->id,
            'month' => $ignoreDay->month ? date('Y-m', strtotime($ignoreDay->month)) : '',
            'date' => $ignoreDay->date ? date('Y-m-d', strtotime($ignoreDay->date)) : '',
            'status' => $ignoreDay->status,
        ]);
    }

    public function update(Request $request, IgnoreDay $ignoreDay)
    {
        $validated = $request->validate([
            'month' => ['required', 'string'],
            'date' => ['required', 'string'],
        ]);

        $ignoreDay = $this->service->update($ignoreDay, $validated);

        return response()->json([
            'message' => 'Ignore day updated successfully',
            'data' => $ignoreDay,
        ]);
    }

    public function destroy(IgnoreDay $ignoreDay)
    {
        $this->service->delete($ignoreDay);

        return response()->json([
            'message' => 'Ignore day deleted successfully',
        ]);
    }
}
