<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('remunerations', function (Blueprint $table) {
            $table->integer('id', true); // signed INT(11) AUTO_INCREMENT PK
            $table->string('remuneration_name', 100);
            $table->string('remuneration_type', 100);
            $table->integer('value_group');
            $table->tinyInteger('epf_payable')->default(0);
            $table->string('allocation_method', 100)->default('TERMS')
                ->comment('FIXED-into-employee-profile-or-TERMS-of-salary-process');
            $table->tinyInteger('advanced_option_id')->default(0)
                ->comment('option-id-related-to-popup-modal-id');
            $table->tinyInteger('employee_work_rate_work_days_exclusions')->default(0)
                ->comment('compare-eligibility-days-0-for-all-work-days-and-1-for-work-days-without-holidays');
            $table->string('payslip_spec_code', 15)->default('OTHER_REM');
            $table->string('taxcalc_spec_code', 20)->nullable()
                ->comment('payslip-spec-code-extended-key');
            $table->tinyInteger('remuneration_cancel')->default(0);
            $table->integer('ot_applicable')->default(0);
            $table->integer('nopay_applicable')->default(0);
            $table->string('created_by', 255)->nullable();
            $table->string('updated_by', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('remunerations');
    }
};