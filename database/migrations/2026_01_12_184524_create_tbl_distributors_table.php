<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tbl_distributor', function (Blueprint $table) {
            $table->increments('idtbl_distributor');
            $table->string('name');
            $table->integer('location');
            $table->string('phone');
            $table->string('email');
            $table->string('nic');
            $table->string('address')->nullable();
            $table->string('image')->nullable();
            $table->integer('status');
            $table->integer('ref')->default(0);
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
        Schema::dropIfExists('tbl_distributor');
    }
};
