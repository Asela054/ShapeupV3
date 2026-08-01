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
        Schema::create('employee_contact_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('emp_id');
            $table->string('emp_address', 255)->nullable();
            $table->string('emp_addressT1', 255)->nullable();
            $table->string('emp_city', 255)->nullable();
            $table->string('emp_province', 255)->nullable();
            $table->string('emp_country', 255)->nullable();
            $table->string('emp_postal_code', 255)->nullable();
            $table->string('personal_number', 45)->nullable();
            $table->string('mobile_number', 45)->nullable();
            $table->string('work_telephone', 45)->nullable();
            $table->string('emp_home_no', 45)->nullable();
            $table->string('emp_email', 255)->nullable();
            $table->string('emp_other_email', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_contact_details');
    }
};
