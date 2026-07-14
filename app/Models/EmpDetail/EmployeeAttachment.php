<?php

namespace App\Models\EmpDetail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EmpDetail\Employee;

class EmployeeAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'emp_id',
        'emp_ath_file_name',
        'emp_ath_size',
        'emp_ath_type',
        'attachment_type',
        'emp_ath_by',
        'emp_ath_time',
        'empcomment',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'emp_id', 'id');
    }
}
