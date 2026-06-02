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
        Schema::create('tbl_distributor_order', function (Blueprint $table) {
            $table->increments('idtbl_dis_orderid');
            $table->string('order_no');
            $table->dateTime('order_date');
            $table->double('total');
            $table->double('discount')->nullable();
            $table->double('discount_percentage')->nullable();
            $table->double('nettotal');
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
            $table->string('remark');
            $table->integer('des_id');
            $table->integer('location_id');
            $table->integer('ref_id');
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
        Schema::dropIfExists('tbl_distributor_order');
    }
};
