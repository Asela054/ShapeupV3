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
        Schema::create('tbl_distributor_customer', function (Blueprint $table) {
            $table->increments('idtbl_discus');
            $table->string('name');
            $table->string('location')->nullable();
            $table->string('phone');
            $table->string('email');
            $table->string('nic');
            $table->string('address')->nullable();
            $table->string('image')->nullable();
            $table->string('vat_num');
            $table->string('buisnesscopyimagepath')->nullable();
            $table->string('dealerboardimagepath')->nullable();
            $table->double('credit_limit');
            $table->integer('credit_type')->default(0);
            $table->integer('status');
            $table->integer('tbl_distributor_idtbl_distributor');
            $table->integer('tbl_area_idtbl_area');
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
        Schema::dropIfExists('tbl_distributor_customer');
    }
};
