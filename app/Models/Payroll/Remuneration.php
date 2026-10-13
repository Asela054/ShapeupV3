<?php

namespace App\Models\Payroll;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Remuneration extends Model
{
    use HasFactory;

    protected $table = 'remunerations';

    protected $fillable = [
        'remuneration_name',
        'remuneration_type',
        'value_group',
        'epf_payable',
        'allocation_method',
        'advanced_option_id',
        'employee_work_rate_work_days_exclusions',
        'payslip_spec_code',
        'taxcalc_spec_code',
        'remuneration_cancel',
        'ot_applicable',
        'nopay_applicable',
        'created_by',
        'updated_by',
    ];

    public function leaveDeductions()
    {
        return $this->hasMany(LeaveDeduction::class, 'remuneration_id');
    }
}
