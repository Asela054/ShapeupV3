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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->string('logo', 45)->nullable();
            $table->string('address');
            $table->string('mobile');
            $table->string('land');
            $table->string('email');
            $table->string('domain_name', 50)->nullable();
            $table->string('epf', 145)->nullable();
            $table->string('etf', 145)->nullable();
            $table->string('employer_number', 8)->nullable();
            $table->string('zone_code', 1)->nullable();
            $table->string('ref_no')->nullable();
            $table->string('vat_reg_no')->nullable();
            $table->string('svat_no')->nullable();
            $table->integer('company_type')->default(0);
            $table->integer('paysheet_language')->default(1)->comment('1=English, 2=Sinhala, 3=Tamil');
            $table->integer('status')->default(0);
            $table->string('created_by');
            $table->string('updated_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
