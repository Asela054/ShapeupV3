<?php

namespace App\Models\EmpMaster;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobTitle extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'occupation_group_id',
    ];
}
