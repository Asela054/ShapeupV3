<?php

namespace App\Models\EmpDetail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EmpDetail\Employee;

class EmployeeLocalAuthorityDetail extends Model
{
    use HasFactory;

    protected $table = 'employee_local_authority_details';
 
    protected $fillable = [
        'emp_id',
        'ds_divition',
        'gsn_divition',
        'gsn_name',
        'gsn_contactno',
        'police_station',
        'police_contactno',
    ];
 
    /**
     * employee_local_authority_details.emp_id → employees.id
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'emp_id', 'id');
    }
}
