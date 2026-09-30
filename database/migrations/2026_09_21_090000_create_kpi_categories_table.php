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
        if (!Schema::hasTable('kpi_categories')) {
            Schema::create('kpi_categories', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->unsignedInteger('parent_id')->nullable();
                $table->text('description')->nullable();
                $table->timestamps();

                $table->foreign('parent_id')->references('id')->on('kpi_categories')->onDelete('cascade');
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
        Schema::dropIfExists('kpi_categories');
    }
};
