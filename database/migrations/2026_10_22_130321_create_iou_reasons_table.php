<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('iou_reasons', function (Blueprint $table) {
            $table->integer('id', true);                    // INT(11) signed AUTO_INCREMENT PK
            $table->string('reason', 100);                  // VARCHAR(100) NOT NULL
            $table->double('estimate_amount')->nullable();  // DOUBLE NULL
            $table->string('remark', 100)->nullable();      // VARCHAR(100) NULL
            $table->integer('status')->default(1);          // when created 1 , deleted 3
            $table->timestamps();                           
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('iou_reasons');
    }
};