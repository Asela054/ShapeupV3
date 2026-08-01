<?php

namespace App\Models\EmpDetail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EmpDetail\Employee;

class EmployeeLicenseDetail extends Model
{
    use HasFactory;

    protected $table = 'employee_license_details';
 
    protected $fillable = [
        'emp_id',
        'emp_drive_license',
        'emp_license_expire_date',
    ];
 
    /**
     * employee_license_details.emp_id → employees.id
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'emp_id', 'id');
    }
}
