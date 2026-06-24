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
        Schema::create('employee_late_attendance_minites', function (Blueprint $table) {
            $table->id();
            $table->integer('attendance_id')->nullable();
            $table->integer('emp_id');
            $table->date('attendance_date')->nullable();
            $table->integer('minites_count')->nullable();
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
        Schema::dropIfExists('employee_late_attendance_minites');
    }
};