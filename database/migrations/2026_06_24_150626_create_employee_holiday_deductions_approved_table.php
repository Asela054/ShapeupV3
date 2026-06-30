<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('holiday_deductions_approved', function (Blueprint $table) {
            $table->id();
            $table->integer('emp_id');
            $table->date('from_date')->nullable();
            $table->date('to_date')->nullable();
            $table->double('total_absent_days')->nullable();
            $table->double('total_amount')->nullable();
            $table->double('monthly_remain')->nullable();
            $table->integer('remuneration_id');
            $table->integer('status')->default(0);
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('holiday_deductions_approved');
    }
};