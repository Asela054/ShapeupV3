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
        Schema::create('tbl_distributor_order_detail', function (Blueprint $table) {
            $table->increments('idtbl_dis_order_detail_id');
            $table->integer('item_id');
            $table->double('item_saleprice');
            $table->float('qty');
            $table->float('freeqty');
            $table->double('total');
            $table->double('item_discount')->nullable();
            $table->double('discount_percentage')->nullable();
            $table->double('nettotal');
            $table->integer('status');
            $table->integer('tbl_distributor_order_id');
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
        Schema::dropIfExists('tbl_distributor_order_detail');
    }
};
