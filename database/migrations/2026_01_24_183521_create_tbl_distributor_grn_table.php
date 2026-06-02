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
        Schema::create('tbl_distributor_grn', function (Blueprint $table) {
            $table->increments('idtbl_grn');
            $table->string('grn_no')->unique();
            $table->date('date');
            $table->double('total')->default(0);
            $table->double('vatamount')->nullable();
            $table->double('nettotal')->nullable();
            $table->string('invoicenum');
            $table->string('dispatchnum');
            $table->string('batchno');
            $table->integer('porder_id');
            $table->integer('distributor_id');
            $table->integer('status')->default(1);
            $table->integer('confirm_status')->default(0);
            $table->integer('transfer_status')->default(0);
            $table->integer('updateuser')->nullable();
            $table->dateTime('updatedatetime')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_distributor_grn');
    }
};
