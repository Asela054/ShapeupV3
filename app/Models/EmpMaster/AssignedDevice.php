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

    public function assignedToEmployees()
    {
        return $this->hasMany(\App\Models\EmpDetail\EmployeeAssignedDevice::class, 'device_type', 'id');
    }
}
