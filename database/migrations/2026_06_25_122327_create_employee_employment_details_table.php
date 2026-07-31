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
        Schema::create('employee_employment_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('emp_id');
            $table->date('emp_join_date')->nullable();
            $table->date('emp_permanent_date')->nullable();
            $table->date('emp_assign_date')->nullable();
            $table->integer('emp_job_title')->nullable();
            $table->integer('emp_company')->nullable();
            $table->integer('emp_location')->nullable();
            $table->integer('emp_department')->nullable();
            $table->integer('emp_shift')->nullable();
            $table->integer('job_category_id')->nullable();
            $table->integer('hierarchy_id')->nullable();
            $table->integer('financial_id')->nullable();
            $table->integer('leave_approve_person')->nullable();
            $table->integer('outstation_payment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_employment_details');
    }
};
