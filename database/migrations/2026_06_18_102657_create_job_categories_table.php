<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('job_categories', function (Blueprint $table) {
            $table->id();
            $table->string('category', 255);
            $table->integer('annual_leaves')->nullable();
            $table->integer('casual_leaves')->nullable();
            $table->integer('medical_leaves')->nullable();
            $table->double('normal_ot_rate', 10, 2)->nullable();
            $table->double('double_ot_rate', 10, 2)->nullable();
            $table->double('no_pay_rate_per_hour', 10, 2)->nullable();
            $table->double('no_pay_rate_per_day', 10, 2)->nullable();
            $table->double('saturday_rate', 10, 2)->nullable();
            $table->double('sunday_rate', 10, 2)->nullable();
            $table->integer('emp_payroll_workdays')->default(0);
            $table->integer('emp_payroll_workhrs')->default(0);
            $table->integer('is_sat_ot_type_as_act');
            $table->double('custom_saturday_ot_type', 10, 2)->nullable();
            $table->integer('is_sun_ot_type_as_act')->nullable();
            $table->double('custom_sunday_ot_type', 10, 2)->nullable();
            $table->double('sun_after_double')->nullable();
            $table->integer('spe_day_1_day')->nullable();
            $table->integer('spe_day_1_type')->nullable();
            $table->double('spe_day_1_rate')->nullable();
            $table->double('ot_app_hours', 10, 2)->nullable();
            $table->integer('holiday_ot_minimum_min');
            $table->integer('holiday_ot_start')->nullable();
            $table->integer('holiday_lunch_deduct')->nullable();
            $table->double('spe_deduct_pre')->nullable();
            $table->integer('lunch_deduct_type')->nullable();
            $table->double('lunch_deduct_min')->nullable();
            $table->integer('morning_ot')->nullable();
            $table->double('shift_hours')->nullable();
            $table->string('work_hour_date', 45)->nullable();
            $table->integer('late_attend_min')->nullable();
            $table->integer('salary_without_attendace')->nullable();
            $table->double('holiday_work_hours')->nullable();
            $table->integer('late_type')->nullable();
            $table->integer('short_leaves')->nullable();
            $table->integer('half_days')->nullable();
            $table->double('week_after_double')->nullable();
            $table->integer('ot_round_time')->nullable();
            $table->integer('flex_ot')->comment('1 = Yes, 0 = No ');
            $table->string('late_deduction_type', 100)->default('0');
            $table->integer('basic_ot_type')->default(1)->comment('1=Basic salary, 2=custom');
            $table->double('custom_normal_ot_rate')->nullable();
            $table->double('custom_double_ot_rate')->nullable();
            $table->integer('salary_advance_type')->nullable()->comment('1=percentage, 2=fixed amount');
            $table->double('salary_advance_value')->nullable();
            $table->double('salary_advance_min_date')->nullable();
            $table->integer('late_deduct_calculation')->default(1)->comment('1=nopay, 2=normalOT, 3=doubleOT');
            $table->double('full_day_work_hours')->nullable();
            $table->integer('status')->default(0);
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_categories');
    }
};