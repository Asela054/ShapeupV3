<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('room_allocations', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('room_id');                     
            $table->integer('emp_id');                      
            $table->dateTime('start_time');
            $table->dateTime('end_time');                
            $table->string('remark', 100)->nullable();
            $table->integer('status')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('room_allocations');
    }
};