<?php

namespace App\Models\EmpDetail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EmpDetail\Employee;

class EmployeeResignationDetail extends Model
{
    use HasFactory;

    protected $table = 'employee_resignation_details';
 
    protected $fillable = [
        'emp_id',
        'resignation_date',
        'resignation_remark',
    ];
 
    /**
     * employee_resignation_details.emp_id → employees.id
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'emp_id', 'id');
    }
}
