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
        Schema::create('employee_assigned_devices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('emp_id');
            $table->integer('device_type');
            $table->string('model_number', 45);
            $table->string('serial_number', 45);
            $table->string('other_ref_number', 45)->nullable();
            $table->date('assigned_date');
            $table->date('returned_date')->nullable();
            $table->integer('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_assigned_devices');
    }
};
