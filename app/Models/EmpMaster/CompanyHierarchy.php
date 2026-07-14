<?php

namespace App\Models\EmpMaster;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyHierarchy extends Model
{
    use HasFactory;

    protected $fillable = [
        'position',
        'order_number',
    ];
}
