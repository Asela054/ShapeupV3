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
        Schema::create('kpi_attributes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description');
            $table->integer('kpi_category_id')->unsigned()->nullable();
            $table->enum('category', ['functional', 'behavioral', 'non_points']);
            $table->decimal('fixed_points', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('kpi_attributes');
    }
};
