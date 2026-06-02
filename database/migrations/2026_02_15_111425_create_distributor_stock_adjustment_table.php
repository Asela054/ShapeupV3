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
        Schema::create('tbl_distributor_stock_adjustment', function (Blueprint $table) {
            $table->increments('idtbl_dis_stock_adjustment');
            $table->integer('adjustmenttype');
            $table->double('adjustqty');
            $table->longText('remarks')->nullable();
            $table->integer('distributor_stock_id');
            $table->string('batchnumber')->nullable();
            $table->integer('product_id');
            $table->dateTime('inserteddatetime');
            $table->integer('status')->default(1);
            $table->integer('distributor_id');
            $table->integer('updateuser');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_distributor_stock_adjustment');
    }
};
