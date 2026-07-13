<?php

namespace App\Models\Organization;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyBankDetail extends Model
{
    use HasFactory;

    protected $table = 'company_bank_details';

    protected $fillable = [
        'company_id',
        'bank_code',
        'branch_code',
        'bank_account_number',
        'bank_account_name',
        'status',
        'created_by',
        'updated_by',
    ];
}