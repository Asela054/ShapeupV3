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
        Schema::create('tbl_customer_assets', function (Blueprint $table) {
            $table->increments('idtbl_customer_assets');
            $table->string('assetname');
            $table->string('description')->nullable();
            $table->integer('status')->default(1);
            $table->integer('updateuser');
            $table->dateTime('updatedatetime');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_customer_assets');
    }
};
