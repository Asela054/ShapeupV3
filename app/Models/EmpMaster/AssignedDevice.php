<?php

namespace App\Models\EmpMaster;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignedDevice extends Model
{
    use HasFactory;

    protected $fillable = [
        'device_name',
        'remarks',
    ];
}
