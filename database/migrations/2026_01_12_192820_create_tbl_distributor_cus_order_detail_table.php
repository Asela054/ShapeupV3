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
        Schema::create('tbl_distributor_cus_order_detail', function (Blueprint $table) {
            $table->increments('idtbl_dis_cus_order_detailid');
            $table->integer('item_id');
            $table->double('item_unitprice')->nullable();
            $table->double('item_saleprice');
            $table->float('qty');
            $table->float('free_qty');
            $table->double('total');
            $table->double('item_discount')->nullable();
            $table->double('discount_percentage')->nullable();
            $table->double('nettotal');
            $table->float('vat_percentage');
            $table->double('vat_value');
            $table->double('nettotal_with_vat');
            $table->integer('status');
            $table->integer('tbl_distributor_cus_order_id');
            $table->integer('tbl_distributor_customer_id');
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
        Schema::dropIfExists('tbl_distributor_cus_order_detail');
    }
};
