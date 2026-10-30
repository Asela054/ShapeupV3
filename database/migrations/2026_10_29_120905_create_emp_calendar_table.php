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
        Schema::create('emp_calendar', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('emp_id');
            $table->string('title', 45);
            $table->date('date');
            $table->time('time');
            $table->string('remark', 100)->nullable();
            $table->integer('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emp_calendar');
    }
};
