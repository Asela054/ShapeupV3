<?php
namespace App\Models\EmpDetail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EmpDetail\Employee;
use App\Models\Organization\Bank;
use App\Models\Organization\BankBranch;

class EmployeeBank extends Model
{
    use HasFactory;

    protected $table = 'employee_banks';

    protected $fillable = [
        'emp_id',
        'bank_code',
        'branch_code',
        'bank_ac_no',
        'status',
    ];

    /**
     * employees.id → employee_banks.emp_id
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'emp_id', 'id');
    }

    /**
     * banks.code → employee_banks.bank_code
     */
    public function bank()
    {
        return $this->belongsTo(Bank::class, 'bank_code', 'code');
    }

    /**
     * bank_branches.code → employee_banks.branch_code
     */
    public function branch()
    {
        return $this->belongsTo(BankBranch::class, 'branch_code', 'code');
    }
}