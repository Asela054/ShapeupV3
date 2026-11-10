<?php

namespace App\Http\Controllers\ActivityManagement\BookingRooms;

use App\Http\Controllers\Controller;
use App\Models\ActivityManagement\BookingRooms\MeetingRoom;
use App\Services\ActivityManagement\BookingRooms\MeetingRoomService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;      // Needed for the Rule::unique() fluent syntax
use Yajra\DataTables\Facades\DataTables;

class MeetingRoomController extends Controller
{
    // This will hold our service class for the crud operations of MeetingRoom
    protected $service;

    // Laravel automatically gives us MeetingRoomService here
    public function __construct(MeetingRoomService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('activity-management.booking-rooms.meeting_rooms');
    }

    // Sends the table data to the page
    public function data(Request $request)
    {
        // Get all meeting rooms EXCEPT deleted ones
        $meetingRooms = MeetingRoom::where('status', '!=', 3);

        return DataTables::of($meetingRooms)
            ->addIndexColumn()
            ->make(true);
    }

    // The validation rules, used by both store() and update()
    protected function rules(?int $meetingRoomId = null): array
    {
        return [
            'name' => [
                'required', 'string', 'max:100',
                Rule::unique('meeting_rooms', 'name')
                    ->ignore($meetingRoomId)
                    ->where(fn ($query) => $query->where('status', '!=', 3)),
            ],
            'remark' => ['nullable', 'string', 'max:100'],
        ];
    }

    // Saves a NEW meeting room
    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        $meetingRoom = $this->service->create($validated);

        return response()->json(['message' => 'Meeting Room created successfully', 'data' => $meetingRoom]);
    }

    // Laravel finds the record automatically from the id
    public function edit(MeetingRoom $meetingRoom)
    {
        return response()->json($meetingRoom);
    }

    // Saves changes to an EXISTING meeting room
    public function update(Request $request, MeetingRoom $meetingRoom)
    {
        // Pass this record's id so it is ignored in the unique check
        $validated = $request->validate($this->rules($meetingRoom->id));

        // Let the service update it in the database
        $meetingRoom = $this->service->update($meetingRoom, $validated);

        return response()->json(['message' => 'Meeting Room updated successfully', 'data' => $meetingRoom]);
    }

    // The service sets status = 3, which is a "soft delete"
    public function destroy(MeetingRoom $meetingRoom)
    {
        $this->service->delete($meetingRoom);

        return response()->json(['message' => 'Meeting Room deleted successfully']);
    }
}