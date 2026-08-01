<?php

namespace App\Models\Organization;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EmpDetail\EmployeeBank;

class BankBranch extends Model
{
    use HasFactory;

    protected $table = 'bank_branches';
    protected $fillable = [
        'bank_code',
        'branch_name',
        'code',
        'status',
        'created_by',
        'updated_by',
    ];

    /**
     * bank_branches.code → employee_banks.branch_code
     */
    public function employeeBanks()
    {
        return $this->hasMany(EmployeeBank::class, 'branch_code', 'code');
    }
}
