<?php

namespace App\Http\Controllers\ActivityManagement;

use App\Http\Controllers\Controller;
use App\Models\ActivityManagement\EmpCalendar;
use App\Services\ActivityManagement\MyCalendarService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MyCalendarController extends Controller
{
    protected $service;

    public function __construct(MyCalendarService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('activity-management.my_calendar', [
            'employees' => $this->service->getEmployees(),
        ]);
    }

    public function data()
    {
        $query = $this->service->getCalendarQuery();

        return DataTables::of($query)
            // Show the employee's name
            ->addColumn('emp_name', function ($row) {
                return $row->employee->emp_name_with_initial ?? '';
            })
            // search emp name
            ->filterColumn('emp_name', function ($query, $keyword) {
                $query->whereHas('employee', function ($q) use ($keyword) {
                    $q->where('emp_name_with_initial', 'like', "%{$keyword}%");
                });
            })
            ->make(true);
    }

    // Saves a NEW calendar event
    public function store(Request $request)
    {
        $validated = $request->validate([
            'emp_id' => ['required', 'integer', 'exists:employees,id'],
            'title'  => ['required', 'string', 'max:45'],
            'date'   => ['required', 'date'],
            'time'   => ['required', 'date_format:H:i'],
            'remark' => ['nullable', 'string', 'max:100'],
        ]);

        // Let the service save it in the database
        $event = $this->service->store($validated);

        return response()->json([
            'success' => true,
            'message' => 'Event added successfully',
            'data'    => $event,
        ]);
    }

    // Laravel finds the record automatically from the id in the URL
    public function edit(EmpCalendar $myCalendar)
    {
        return response()->json([
            'success' => true,
            'data'    => [
                'id'     => $myCalendar->id,
                'emp_id' => $myCalendar->emp_id,
                'title'  => $myCalendar->title,
                'date'   => $myCalendar->date,
                'time'   => $myCalendar->time,
                'remark' => $myCalendar->remark,
            ],
        ]);
    }

    // Saves changes to an EXISTING calendar event
    public function update(Request $request, EmpCalendar $myCalendar)
    {
        $validated = $request->validate([
            'emp_id' => ['required', 'integer', 'exists:employees,id'],
            'title'  => ['required', 'string', 'max:45'],
            'date'   => ['required', 'date'],
            'time'   => ['required', 'date_format:H:i'],
            'remark' => ['nullable', 'string', 'max:100'],
        ]);

        // Let the service update it in the database
        $updatedEvent = $this->service->update($myCalendar, $validated);

        return response()->json([
            'success' => true,
            'message' => 'Event updated successfully',
            'data'    => $updatedEvent,
        ]);
    }

    // Soft delete
    public function destroy(EmpCalendar $myCalendar)
    {
        $this->service->delete($myCalendar);

        return response()->json([
            'success' => true,
            'message' => 'Event deleted successfully',
        ]);
    }
}