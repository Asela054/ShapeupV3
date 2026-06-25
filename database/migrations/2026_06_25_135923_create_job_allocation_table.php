<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_allocation', function (Blueprint $table) {
            $table->id();
            $table->integer('location_id');
            $table->integer('employee_id');
            $table->integer('shiftid');
            $table->integer('status');
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_allocation');
    }
};