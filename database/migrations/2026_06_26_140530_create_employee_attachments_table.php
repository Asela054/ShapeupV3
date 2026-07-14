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
        Schema::create('employee_attachments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('emp_id');
            $table->string('emp_ath_file_name');
            $table->string('emp_ath_size')->nullable();
            $table->string('emp_ath_type')->nullable();
            $table->integer('attachment_type')->nullable();
            $table->string('emp_ath_by')->nullable();
            $table->string('emp_ath_time')->nullable();
            $table->string('empcomment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_attachments');
    }
};
