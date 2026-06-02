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
        Schema::create('tbl_distributor_grn_detail', function (Blueprint $table) {
            $table->increments('idtbl_grn_detail');
            $table->date('date');
            $table->integer('type')->default(0);
            $table->double('qty')->default(0);
            $table->double('unitprice')->nullable();
            $table->double('saleprice')->nullable();
            $table->double('retailprice')->nullable();
            $table->double('total')->default(0);
            $table->integer('grn_id');
            $table->integer('product_id');
            $table->integer('status')->default(1);
            $table->dateTime('insertdatetime');
            $table->integer('updateuser')->nullable();
            $table->dateTime('updatedatetime')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_distributor_grn_detail');
    }
};
