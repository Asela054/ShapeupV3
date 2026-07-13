<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leave_request', function (Blueprint $table) {
            $table->id();
            $table->integer('emp_id');
            $table->date('from_date');
            $table->date('to_date');
            $table->string('leave_category', 100);
            $table->string('reason')->nullable();
            $table->integer('leave_type')->nullable();
            $table->time('from_time')->nullable();
            $table->time('to_time')->nullable();
            $table->integer('status');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('approve_status');
            $table->integer('request_approve_status');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leave_request');
    }
};