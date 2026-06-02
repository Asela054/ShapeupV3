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
        Schema::create('tbl_api_idempotency', function (Blueprint $table) {
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_0900_ai_ci';

            $table->increments('idtbl_api_idempotency');
            $table->string('idempotency_key', 128);
            $table->string('endpoint', 120);
            $table->char('request_hash', 64);
            $table->longText('request_body')->nullable();
            $table->integer('response_status')->nullable();
            $table->longText('response_body')->nullable();
            $table->tinyInteger('process_status')->default(1)->comment('1=processing,2=completed,3=failed');
            $table->integer('status')->default(1);
            $table->dateTime('insertdatetime');
            $table->dateTime('updatedatetime')->nullable();
            $table->integer('tbl_user_idtbl_user');

            $table->unique(['idempotency_key', 'endpoint', 'tbl_user_idtbl_user'], 'uk_api_idempotency_key');
            $table->index(['process_status', 'status'], 'idx_api_idempotency_status');
            $table->index('updatedatetime', 'idx_api_idempotency_updatedatetime');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_api_idempotency');
    }
};
