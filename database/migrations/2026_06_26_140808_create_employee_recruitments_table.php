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
        Schema::create('employee_recruitments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('emp_id');
            $table->unsignedBigInteger('first_interviwer');
            $table->date('first_interview_date')->nullable();
            $table->string('first_interview_outcome', 45)->nullable();
            $table->string('first_interview_comments')->nullable();
            $table->unsignedBigInteger('second_interviewer')->nullable();
            $table->date('second_interview_date')->nullable();
            $table->string('second_interview_outcome', 45)->nullable();
            $table->string('second_interview_comments')->nullable();
            $table->unsignedBigInteger('third_interviewer')->nullable();
            $table->date('third_interview_date')->nullable();
            $table->string('third_interview_outcome', 45)->nullable();
            $table->string('third_interview_comments')->nullable();
            $table->integer('status');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_recruitments');
    }
};
