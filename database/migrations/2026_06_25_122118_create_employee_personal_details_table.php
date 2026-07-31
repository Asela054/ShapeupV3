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
        Schema::create('employee_personal_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('emp_id');
            $table->string('emp_first_name', 255);
            $table->string('emp_med_name', 255)->nullable();
            $table->string('emp_last_name', 255);
            $table->string('emp_fullname', 255)->nullable();
            $table->string('emp_nick_name', 100)->nullable();
            $table->string('emp_gender', 50)->nullable();
            $table->string('emp_marital_status', 50)->nullable();
            $table->string('emp_nationality', 50)->nullable();
            $table->date('emp_birthday')->nullable();
            $table->string('emp_national_id', 50)->nullable();
            $table->string('emp_salary_grade', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_personal_details');
    }
};
