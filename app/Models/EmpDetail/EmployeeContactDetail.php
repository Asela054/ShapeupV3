<?php

namespace App\Models\EmpDetail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EmpDetail\Employee;

class EmployeeContactDetail extends Model
{
    use HasFactory;

    protected $table = 'employee_contact_details';
 
    protected $fillable = [
        'emp_id',
        'emp_address',
        'emp_addressT1',
        'emp_city',
        'emp_province',
        'emp_country',
        'emp_postal_code',
        'personal_number',
        'mobile_number',
        'work_telephone',
        'emp_home_no',
        'emp_email',
        'emp_other_email',
    ];
 
    /**
     * employee_contact_details.emp_id → employees.id
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'emp_id', 'id');
    }
}
