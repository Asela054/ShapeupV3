<?php

namespace App\Models\EmpMaster;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayGrade extends Model
{
    use HasFactory;

    protected $fillable = [
        'pay_grade',
    ];
}
