<?php

namespace App\Models\Organization;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'code', 'logo', 'address', 'mobile', 'land', 'email',
        'domain_name', 'epf', 'etf', 'employer_number', 'zone_code',
        'ref_no', 'vat_reg_no', 'svat_no', 'company_type',
        'paysheet_language', 'status', 'created_by', 'updated_by',
    ];

    protected $casts = [
        'company_type' => 'integer',
        'paysheet_language' => 'integer',
    ];

    public function bankDetails()
    {
        return $this->hasMany(CompanyBankDetail::class, 'company_id');
    }
}