<?php

namespace App\Models\ActivityManagement\BookingRooms;

use App\Models\EmpDetail\Employee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomAllocation extends Model
{
    use HasFactory;

    protected $table = 'room_allocations';

    // Only these columns can be filled in through create, update
    protected $fillable = [
        'room_id',
        'emp_id',
        'start_time',
        'end_time',
        'remark',
        'status',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time'   => 'datetime',
    ];

    // Foreign keys
    public function room()
    {
        return $this->belongsTo(MeetingRoom::class, 'room_id', 'id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'emp_id', 'id');
    }
}