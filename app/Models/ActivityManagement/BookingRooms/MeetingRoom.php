<?php

namespace App\Models\ActivityManagement\BookingRooms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Model for the meeting_rooms table
class MeetingRoom extends Model
{
    use HasFactory;

    // Only these columns can be filled in through create, update
    protected $fillable = [
        'name',
        'remark',
        'status',
    ];
}