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
        Schema::create('tbl_distributor_porder', function (Blueprint $table) {
            $table->increments('idtbl_porder');
            $table->string('order_no')->unique();
            $table->date('order_date');
            $table->double('total')->default(0);
            $table->double('vat')->default(0);
            $table->double('nettotal')->default(0);
            $table->double('vatpre')->default(0);
            $table->longText('remarks')->nullable();
            $table->integer('completestatus')->default(0);
            $table->integer('confirmstatus')->default(0);
            $table->integer('grnissuestatus')->default(0);
            $table->integer('location_id')->default(0);
            $table->integer('distributor_id')->default(0);
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
        Schema::dropIfExists('tbl_distributor_porder');
    }
};
