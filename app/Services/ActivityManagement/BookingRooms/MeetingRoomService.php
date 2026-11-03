<?php

namespace App\Services\ActivityManagement\BookingRooms;

use App\Models\ActivityManagement\BookingRooms\MeetingRoom;
use Illuminate\Support\Facades\DB;

// Service = where the real database work happens
class MeetingRoomService
{
    public function create(array $data): MeetingRoom
    {
        // Saves a new meeting room
        return DB::transaction(function () use ($data) {
            $data['status'] = 1; // active on create

            return MeetingRoom::create($data);
        });
    }

    // Updates an existing meeting room with the validated form data
    public function update(MeetingRoom $meetingRoom, array $data): MeetingRoom
    {
        return DB::transaction(function () use ($meetingRoom, $data) {
            $meetingRoom->update($data);

            return $meetingRoom;
        });
    }

    // Doesn't remove the row, just sets status to 3
    public function delete(MeetingRoom $meetingRoom): void
    {
        DB::transaction(function () use ($meetingRoom) {
            $meetingRoom->update(['status' => 3]); // soft delete
        });
    }
}