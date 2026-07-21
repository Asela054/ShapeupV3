<?php

namespace App\Models\Attendance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class fingerprint_devices extends Model
{
    use HasFactory;

    protected $fillable = [
        'ip',
        'name',
        'sno',
        'emi',
        'conection_no',
        'location',
        'status',
        'created_by',
        'updated_by',
    ];
}
