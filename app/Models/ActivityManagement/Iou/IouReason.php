<?php

namespace App\Models\ActivityManagement\Iou;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Model for the iou_reasons table
class IouReason extends Model
{
    use HasFactory;

    // Only these columns can be filled in through crate,update
    protected $fillable = [
        'reason',
        'estimate_amount',
        'remark',
        'status',
    ];
}