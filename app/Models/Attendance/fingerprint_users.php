<?php

namespace App\Models\Attendance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class fingerprint_users extends Model
{
    use HasFactory;

    protected $fillable = [
        'userid',
        'name',
        'cardno',
        'role',
        'password',
        'devicesno',
        'location',
        'status',
        'created_by',
        'updated_by',
    ];
}
