<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employee_work_rates', function (Blueprint $table) {
            $table->id();
            $table->integer('emp_id');
            $table->string('emp_etfno')->nullable();
            $table->integer('work_year');
            $table->integer('work_month');
            $table->double('work_days');
            $table->double('working_week_days')->default(0);
            $table->double('work_hours');
            $table->double('leave_days');
            $table->double('nopay_days');
            $table->double('emp_late_hours')->default(0)->comment('employee-monthly-late-hours-for-next-month-advance-deduction');
            $table->double('normal_rate_otwork_hrs');
            $table->double('double_rate_otwork_hrs');
            $table->double('triple_rate_otwork_hrs')->default(0);
            $table->double('holiday_nopay_days')->nullable();
            $table->double('holiday_normal_ot_hrs')->nullable();
            $table->double('holiday_double_ot_hrs')->nullable();
            $table->string('created_by');
            $table->string('updated_by');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employee_work_rates');
    }
};