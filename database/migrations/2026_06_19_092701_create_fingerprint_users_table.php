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
        Schema::create('fingerprint_users', function (Blueprint $table) {
            $table->id();
            $table->integer('userid'); 
            $table->string('name'); 
            $table->string('cardno');  
            $table->string('role'); 
            $table->string('password'); 
            $table->string('devicesno');
            $table->integer('location'); 
            $table->integer('status'); 
            $table->integer('created_by')->nullable();  
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fingerprint_users');
    }
};
