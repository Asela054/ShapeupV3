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
        Schema::create('employee_exam_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('emp_id');
            $table->string('exam_type', 45);
            $table->unsignedBigInteger('subject_id');
            $table->string('grade', 45);
            $table->string('school');
            $table->integer('medium');
            $table->year('year');
            $table->string('center_no', 45)->nullable()->default('0');
            $table->integer('index_no')->nullable()->default(0);
            $table->integer('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_exam_results');
    }
};
