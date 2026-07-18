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
        Schema::create('employee_dependent_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('emp_id');
            $table->string('emp_dep_name');
            $table->string('emp_dep_relation');
            $table->string('emp_dep_type')->nullable();
            $table->date('emp_dep_birthday')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_dependent_details');
    }
};
