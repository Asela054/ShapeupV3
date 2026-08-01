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
        Schema::create('employee_local_authority_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('emp_id');
            $table->string('ds_divition', 255)->nullable();
            $table->string('gsn_divition', 255)->nullable();
            $table->string('gsn_name', 255)->nullable();
            $table->string('gsn_contactno', 255)->nullable();
            $table->string('police_station', 255)->nullable();
            $table->string('police_contactno', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_local_authority_details');
    }
};
