<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        if (!Schema::hasTable('kpi_years')) {
            Schema::create('kpi_years', function (Blueprint $table) {
                $table->increments('id');
                $table->string('year_name');
                $table->date('start_date');
                $table->date('end_date');
                $table->enum('status', ['active', 'closed'])->default('active');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('kpi_years');
    }
};
