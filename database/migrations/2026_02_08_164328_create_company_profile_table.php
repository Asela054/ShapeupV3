<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('company_profile', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->tinyInteger('type');
            $table->string('tin')->nullable();
            $table->unsignedBigInteger('area_id');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->string('payment_person_name')->nullable();
            $table->string('payment_person_mobile')->nullable();
            $table->string('vat_num')->nullable();
            $table->string('s_vat')->nullable();
            $table->string('company_logo')->nullable();
            $table->string('business_copy')->nullable();
            $table->string('dealer_board')->nullable();
            $table->string('shop_image')->nullable();
            $table->text('remarks')->nullable();
            $table->text('comment')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('company_profile');
    }
};
