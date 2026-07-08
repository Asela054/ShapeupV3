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
        Schema::create('salary_adjustments', function (Blueprint $table) {
            $table->id();
            $table->integer('emp_id')->default(0);
            $table->integer('job_id');
            $table->integer('remuneration_id');
            $table->integer('adjustment_type')->default(0)->comment('1=emp, 2=job category');
            $table->integer('allowance_type');
            $table->double('amount');
            $table->double('allowleave');
            $table->integer('approved_status')->nullable();
            $table->string('approved_by', 255)->nullable();
            $table->dateTime('approved_at')->nullable();
            $table->integer('status')->default(0);
            $table->string('created_by', 255)->nullable();
            $table->string('updated_by', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salary_adjustments');
    }
};