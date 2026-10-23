<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('iou_requests', function (Blueprint $table) {
            $table->integer('id', true);                    
            $table->integer('reason_id');                   
            $table->integer('emp_id');                      
            $table->double('amount');                       
            $table->string('remark', 100)->nullable();      
            $table->integer('status')->default(0);          
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('iou_requests');
    }
};