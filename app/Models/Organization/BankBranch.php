<?php

namespace App\Models\Organization;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankBranch extends Model
{
    use HasFactory;

     protected $fillable = [
        'bank_code',
        'branch_name',
        'code',
        'status',
        'created_by',
        'updated_by',
    ];
}
