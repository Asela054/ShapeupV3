<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employee_late_attendances', function (Blueprint $table) {
            $table->id();
            $table->integer('attendance_id');
            $table->integer('emp_id');
            $table->date('date');
            $table->time('check_in_time');
            $table->time('check_out_time');
            $table->time('working_hours');
            $table->integer('status')->default(0);
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->integer('is_approved')->default(0);
            $table->integer('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employee_late_attendances');
    }
};