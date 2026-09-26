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
        if (!Schema::hasTable('employee_kpi_performances')) {
            Schema::create('employee_kpi_performances', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('employee_id')->unsigned();
                $table->integer('evaluation_year_id')->unsigned();
                $table->enum('period', ['mid_year', 'annual'])->default('mid_year');
                $table->integer('kpi_attribute_id')->unsigned();
                $table->decimal('self_score', 5, 2)->nullable();
                $table->decimal('supervisor_score', 5, 2)->nullable();
                $table->text('remark')->nullable();
                $table->integer('created_by')->unsigned()->nullable();
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
        Schema::dropIfExists('employee_kpi_performances');
    }
};
