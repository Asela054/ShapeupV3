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
        Schema::create('tbl_distributor_cus_order', function (Blueprint $table) {
            $table->increments('idtbl_dis_cus_orderid');
            $table->string('order_no');
            $table->dateTime('order_date');
            $table->double('total');
            $table->double('discount')->nullable();
            $table->double('discount_percentage')->nullable();
            $table->double('nettotal');
            $table->float('vat_percentage')->nullable();
            $table->double('vat_value')->nullable();
            $table->double('nettotal_with_vat')->nullable();
            $table->integer('confirm')->default(0);
            $table->integer('confirm_user')->default(0);
            $table->dateTime('confirm_date')->nullable();
            $table->integer('dispatch')->default(0);
            $table->integer('dispatch_user')->default(0);
            $table->dateTime('dispatch_date')->nullable();
            $table->integer('deliver')->default(0);
            $table->integer('deliver_user')->default(0);
            $table->dateTime('deliver_date')->nullable();
            $table->integer('status');
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
        Schema::dropIfExists('tbl_distributor_cus_order');
    }
};
