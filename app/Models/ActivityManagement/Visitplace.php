<?php

namespace App\Models\ActivityManagement;

use App\Models\EmpDetail\Employee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Model for the visit_places table
class VisitPlace extends Model
{
    use HasFactory;

    protected $table = 'visit_places';

    //columns can be filled in create, update
    protected $fillable = [
        'emp_id',
        'place',
        'date',
        'time',
        'latitude',
        'longitude',
        'remark',
        'status',
    ];

    // Foreign key
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'emp_id', 'id');
    }
}