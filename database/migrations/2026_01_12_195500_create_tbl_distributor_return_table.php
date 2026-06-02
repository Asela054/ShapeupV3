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
        Schema::create('tbl_distributor_return', function (Blueprint $table) {
            $table->increments('idtbl_dis_returnid');
            $table->integer('invoice_id');
            $table->integer('order_id');
            $table->integer('item_id');
            $table->float('qty');
            $table->integer('stock_id');
            $table->integer('return_type');
            $table->string('reason')->nullable();
            $table->dateTime('date');
            $table->string('comments')->nullable();
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
        Schema::dropIfExists('tbl_distributor_return');
    }
};
