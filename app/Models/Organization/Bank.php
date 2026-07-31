<?php

namespace App\Models\Organization;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EmpDetail\EmployeeBank;

class Bank extends Model
{
    use HasFactory;

    protected $table = 'banks';
    protected $fillable = [
        'name',
        'code',
        'status',
        'created_by',
        'updated_by',
    ];

    /**
     * banks.code → employee_banks.bank_code
     */
    public function employeeBanks()
    {
        return $this->hasMany(EmployeeBank::class, 'bank_code', 'code');
    }
}
