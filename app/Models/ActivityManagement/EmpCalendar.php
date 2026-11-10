<?php

namespace App\Models\ActivityManagement;

use App\Models\EmpDetail\Employee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Model for the emp_calendar table
class EmpCalendar extends Model
{
    use HasFactory;

    protected $table = 'emp_calendar';

    // columns can be filled in create, update
    protected $fillable = [
        'emp_id',
        'title',
        'date',
        'time',
        'remark',
        'status',
    ];

    // Foreign key
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'emp_id', 'id');
    }
}