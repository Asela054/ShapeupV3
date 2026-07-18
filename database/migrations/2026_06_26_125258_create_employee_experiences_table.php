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
        Schema::create('employee_experiences', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('emp_id');
            $table->string('emp_company');
            $table->string('emp_jobtitle');
            $table->date('emp_from_date');
            $table->date('emp_to_date');
            $table->string('emp_comment');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_experiences');
    }
};
