<?php

namespace App\Services\ActivityManagement\BookingRooms;

use App\Models\ActivityManagement\BookingRooms\MeetingRoom;
use App\Models\ActivityManagement\BookingRooms\RoomAllocation;
use App\Models\EmpDetail\Employee;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class RoomAllocationService
{
    // Base query for the Room Allocation list
    public function getRoomAllocationQuery()
    {
        return RoomAllocation::query()
            ->with(['employee', 'room'])
            ->where('status', '!=', 3);  // hide soft-deleted requests
    }

    // Employees for the dropdown
    public function getEmployees()
    {
        return Employee::where('deleted', 0)
            ->orderBy('emp_name_with_initial')
            ->get();
    }

    // Only active rooms
    public function getRooms()
    {
        return MeetingRoom::where('status', 1)
            ->orderBy('name')
            ->get();
    }

    // Saves a new Room Allocation request
    public function store(array $data): RoomAllocation
    {
        $this->ensureRoomIsAvailable($data);

        return DB::transaction(function () use ($data) {
            return RoomAllocation::create([
                'emp_id'    => $data['emp_id'],
                'room_id'   => $data['room_id'],
                'start_time' => Carbon::parse($data['start_time']),
                'end_time'   => Carbon::parse($data['end_time']),
                'remark'    => $data['remark'] ?? null,
                'status'    => 0,
            ]);
        });
    }

    public function find(int $id): ?RoomAllocation
    {
        return RoomAllocation::find($id);
    }

    // Updates an existing request with the validated form data
    public function update(RoomAllocation $roomAllocation, array $data): RoomAllocation
    {
        $this->ensureRoomIsAvailable($data, $roomAllocation->id);

        return DB::transaction(function () use ($roomAllocation, $data) {
            $roomAllocation->update([
                'emp_id'    => $data['emp_id'],
                'room_id'   => $data['room_id'],
                'start_time' => Carbon::parse($data['start_time']),
                'end_time'   => Carbon::parse($data['end_time']),
                'remark'    => $data['remark'] ?? null,
            ]);

            return $roomAllocation->fresh();
        });
    }

     // Soft delete
    public function delete(RoomAllocation $roomAllocation): ?bool
    {
        return DB::transaction(function () use ($roomAllocation) {
            return $roomAllocation->update(['status' => 3]);
        });
    }

    // Stops two bookings for the same room at the same time
    private function ensureRoomIsAvailable(array $data, ?int $ignoreId = null): void
    {
        $start = Carbon::parse($data['start_time']);
        $end   = Carbon::parse($data['end_time']);

        $query = RoomAllocation::where('room_id', $data['room_id'])
        ->where('start_time', '<', $end) // existing.start < new.end
        ->where('end_time', '>', $start) // existing.end   > new.start
        ->where('status', '!=', 3);   // deleted bookings don't block

      if ($ignoreId) {
        $query->where('id', '!=', $ignoreId);   // ignore itself when editing
      }

      if ($query->exists()) {
        throw ValidationException::withMessages([
            'start_time' => 'This room is already booked for the selected time.',
        ]);
      }
    }

    
}