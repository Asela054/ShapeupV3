<?php

namespace App\Models\EmpDetail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EmpDetail\Employee;

class EmployeeEmergencyContact extends Model
{
    use HasFactory;

    protected $table = 'employee_emergency_contacts';
 
    protected $fillable = [
        'emp_id',
        'person_name',
        'relationship',
        'address',
        'contact_number',
    ];
 
    /**
     * employee_emergency_contacts.emp_id → employees.id
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'emp_id', 'id');
    }
}
