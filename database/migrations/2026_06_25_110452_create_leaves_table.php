<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();
            $table->string('emp_id');
            $table->string('leave_type');
            $table->string('leave_from');
            $table->string('leave_to');
            $table->decimal('no_of_days', 10, 2);
            $table->decimal('half_short', 10, 2);
            $table->string('reson');
            $table->string('comment')->nullable();
            $table->string('emp_covering');
            $table->string('leave_approv_person');
            $table->string('leave_category', 50)->nullable();
            $table->string('status');
            $table->integer('request_id')->nullable();
            $table->integer('approve_01')->default(0);
            $table->dateTime('approve_01_time')->nullable();
            $table->integer('approve_01_by')->nullable();
            $table->integer('approve_02')->default(0);
            $table->dateTime('approve_02_time')->nullable();
            $table->integer('approve_02_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leaves');
    }
};