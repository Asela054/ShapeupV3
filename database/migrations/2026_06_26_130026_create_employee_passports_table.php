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
        Schema::create('employee_passports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('emp_id');
            $table->date('emp_pass_issue_date');
            $table->date('emp_pass_expire_date');
            $table->text('emp_pass_comments');
            $table->string('emp_pass_type');
            $table->string('emp_pass_status');
            $table->string('emp_pass_review');
            $table->string('epf_no', 250)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_passports');
    }
};
