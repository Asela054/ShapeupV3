<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('location_visit_allowances', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id');
            $table->date('from_date');
            $table->date('to_date');
            $table->integer('visit_count');
            $table->double('amount');
            $table->integer('status')->default(0);
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('location_visit_allowances');
    }
};