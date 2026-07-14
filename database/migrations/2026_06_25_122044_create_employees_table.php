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
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('emp_id');
            $table->integer('emp_fp_id');
            $table->string('emp_etf_no', 150);
            $table->string('service_no', 150);
            $table->string('emp_epf_no', 150);
            $table->integer('is_resigned');
            $table->string('emp_name_with_initial', 255);
            $table->string('calling_name', 255);
            $table->integer('deleted');
            $table->integer('factory_id')->nullable();
            $table->integer('emp_status');
            $table->integer('modified_user_id')->nullable();
            $table->integer('created_by')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
