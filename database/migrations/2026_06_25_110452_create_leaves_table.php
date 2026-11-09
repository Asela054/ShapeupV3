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
            $table->integer('emp_id');
            $table->string('leave_type', 255);
            $table->date('leave_from');
            $table->date('leave_to');
            $table->decimal('no_of_days', 10, 2);
            $table->decimal('half_short', 10, 2);
            $table->string('reason', 255);
            $table->string('comment', 255)->nullable();
            $table->string('emp_covering', 255);
            $table->string('leave_approve_person', 255);
            $table->integer('leave_approve_person_2')->nullable();
            $table->string('leave_category', 50)->nullable();
            $table->string('status', 255);
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