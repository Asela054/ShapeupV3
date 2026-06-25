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
        Schema::create('job_attendance', function (Blueprint $table) {
            $table->id();
            $table->date('attendance_date');
            $table->integer('employee_id');
            $table->integer('shift_id');
            $table->dateTime('on_time')->nullable();
            $table->dateTime('off_time')->nullable();
            $table->string('reason', 255)->nullable();
            $table->integer('location_id');
            $table->integer('allocation_id')->nullable();
            $table->integer('status');
            $table->integer('location_status');
            $table->integer('approve_status');
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
        Schema::dropIfExists('job_attendance');
    }
};