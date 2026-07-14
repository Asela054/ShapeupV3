<?php

namespace App\Models\EmpDetail;

use App\Models\EmpDetail\Employee;
use App\Models\EmpMaster\AssignedDevice;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeAssignedDevice extends Model
{
    use HasFactory;

    protected $fillable = [
        'emp_id',
        'device_type',
        'model_number',
        'serial_number',
        'other_ref_number',
        'assigned_date',
        'returned_date',
        'status',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'emp_id', 'id');
    }

    public function deviceType()
    {
        return $this->belongsTo(AssignedDevice::class, 'device_type', 'id');
    }
}
