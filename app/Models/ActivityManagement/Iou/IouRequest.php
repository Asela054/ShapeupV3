<?php

namespace App\Models\ActivityManagement\Iou;

use App\Models\EmpDetail\Employee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Model for the iou_requests table
class IouRequest extends Model
{
    use HasFactory;

    protected $table = 'iou_requests';

    // Only these columns can be filled in through create, update
    protected $fillable = [
        'reason_id',
        'emp_id',
        'amount',
        'remark',
        'status',
    ];

    // Foreign key: iou_requests.reason_id -> iou_reasons.id
    public function reason()
    {
        return $this->belongsTo(IouReason::class, 'reason_id', 'id');
    }

    // Foreign key: iou_requests.emp_id -> employees.id
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'emp_id', 'id');
    }
}