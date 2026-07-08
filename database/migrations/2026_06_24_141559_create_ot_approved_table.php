<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ot_approved', function (Blueprint $table) {
            $table->id();
            $table->integer('emp_id');
            $table->date('date');
            $table->dateTime('from');
            $table->dateTime('to');
            $table->double('hours', 10, 2)->nullable();
            $table->double('double_hours', 10, 2)->nullable();
            $table->double('triple_hours')->nullable();
            $table->double('holiday_normal_hours')->nullable();
            $table->double('holiday_double_hours')->nullable();
            $table->tinyInteger('is_holiday');
            $table->integer('status')->nullable();
            $table->integer('created_by')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ot_approved');
    }
};