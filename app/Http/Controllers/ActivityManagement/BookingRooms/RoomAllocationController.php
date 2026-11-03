<?php

namespace App\Http\Controllers\ActivityManagement\BookingRooms;

use App\Http\Controllers\Controller;
use App\Models\ActivityManagement\BookingRooms\RoomAllocation;
use App\Services\ActivityManagement\BookingRooms\RoomAllocationService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RoomAllocationController extends Controller
{
    protected $service;

    public function __construct(RoomAllocationService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('activity-management.booking-rooms.room_allocations', [
            'employees' => $this->service->getEmployees(),
            'rooms'     => $this->service->getRooms(),
        ]);
    }

    public function data()
    {
        $query = $this->service->getRoomAllocationQuery();

        return DataTables::of($query)
            // Show the employee's nam
            ->addColumn('emp_name', function ($row) {
                return $row->employee->emp_name_with_initial ?? '';
            })
            // Show the room name
            ->addColumn('room_name', function ($row) {
            return $row->room->name ?? '';
            })
            ->editColumn('start_time', function ($row) {
            return $row->start_time ? $row->start_time->format('Y-m-d H:i') : '';
            })
            ->editColumn('end_time', function ($row) {
            return $row->end_time ? $row->end_time->format('Y-m-d H:i') : '';
            })
            // search emp name
            ->filterColumn('emp_name', function ($query, $keyword) {
            $query->whereHas('employee', function ($q) use ($keyword) {
            $q->where('emp_name_with_initial', 'like', "%{$keyword}%");
            });
            })
            // search room name
            ->filterColumn('room_name', function ($query, $keyword) {
            $query->whereHas('room', function ($q) use ($keyword) {
            $q->where('name', 'like', "%{$keyword}%");
            });
            })
            ->make(true);
    }

    // Saves a NEW IOU request
    public function store(Request $request)
    {
        $validated = $request->validate([
            'emp_id'    => ['required', 'integer', 'exists:employees,id'],
            'room_id'      => ['required', 'integer', 'exists:meeting_rooms,id,status,1'],
            'start_time' => ['required', 'date'],
            'end_time'   => ['required', 'date', 'after:start_time'],
            'remark'    => ['nullable', 'string', 'max:100'],
        ]);

        // Let the service save it in the database
        $roomAllocation = $this->service->store($validated);

        return response()->json([
            'success' => true,
            'message' => 'Room Allocation added successfully',
            'data'    => $roomAllocation,
        ]);
    }

     // Laravel finds the record automatically from the id in the UR
    public function edit(RoomAllocation $roomAllocation)
    {
        return response()->json([
            'success' => true,
            'data'    => [
                'id'           => $roomAllocation->id,
                'emp_id'    => $roomAllocation->emp_id,
                'room_id'      => $roomAllocation->room_id,
                'start_time' => $roomAllocation->start_time->format('Y-m-d\TH:i'),
                'end_time'   => $roomAllocation->end_time->format('Y-m-d\TH:i'),
                'remark'    => $roomAllocation->remark,
            ],
        ]);
    }

    // Saves changes to an EXISTING IOU request
    public function update(Request $request, RoomAllocation $roomAllocation)
    {
        $validated = $request->validate([
            'emp_id'    => ['required', 'integer', 'exists:employees,id'],
            'room_id'      => ['required', 'integer', 'exists:meeting_rooms,id,status,1'],
            'start_time' => ['required', 'date'],
            'end_time'   => ['required', 'date', 'after:start_time'],
            'remark'    => ['nullable', 'string', 'max:100'],
        ]);

        // Let the service update it in the database
        $updatedRequest = $this->service->update($roomAllocation, $validated);

        return response()->json([
            'success' => true,
            'message' => 'Room Allocation updated successfully',
            'data'    => $updatedRequest,
        ]);
    }

    // Soft delete
    public function destroy(RoomAllocation $roomAllocation)
    {
        $this->service->delete($roomAllocation);

        return response()->json([
            'success' => true,
            'message' => 'Room Allocation deleted successfully',
        ]);
    }
}