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
        Schema::create('tbl_distributor_stock', function (Blueprint $table) {
            $table->increments('idtbl_dis_stockid');
            $table->string('batchno');
            $table->integer('item_id');
            $table->double('item_saleprice');
            $table->double('item_bulkprice');
            $table->float('batch_qty')->default(0);
            $table->float('qty')->default(0);
            $table->integer('status');
            $table->integer('tbl_distributor_idtbl_distributor');
            $table->integer('tbl_user_idtbl_user');
            $table->dateTime('insert_time');
            $table->dateTime('update_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_distributor_stock');
    }
};
