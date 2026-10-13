<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leave_deductions', function (Blueprint $table) {
            $table->increments('id'); // INT(11) AUTO_INCREMENT PK
            $table->integer('job_id');
            $table->integer('remuneration_id');
            $table->double('day_count');
            $table->double('amount');
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('leave_deductions');
    }
};