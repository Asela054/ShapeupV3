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
        Schema::create('tbl_distributor_invoice', function (Blueprint $table) {
            $table->increments('idtbl_dis_invoiceid');
            $table->string('invoice_no');
            $table->dateTime('invoice_date');
            $table->integer('order_id');
            $table->double('total')->nullable();
            $table->double('discount')->nullable();
            $table->double('discount_percentage')->nullable();
            $table->double('nettotal');
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
        Schema::dropIfExists('tbl_distributor_invoice');
    }
};
