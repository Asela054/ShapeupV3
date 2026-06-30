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
        Schema::create('shift_types', function (Blueprint $table) {
            $table->id();
            $table->string('shift_code', 20);
            $table->string('shift_name', 255);
            $table->string('onduty_time', 255);
            $table->string('offduty_time', 255);
            $table->time('saturday_onduty_time');
            $table->time('saturday_offduty_time');
            $table->string('late_time', 255);
            $table->string('leave_early_time', 255);
            $table->string('begining_checkin', 255);
            $table->string('begining_checkout', 255);
            $table->string('ending_checkin', 255)->nullable();
            $table->string('ending_checkout', 255)->nullable();
            $table->string('workdays_count', 255);
            $table->string('minute_count', 255);
            $table->string('must_checkin', 255)->nullable();
            $table->string('must_checkout', 255)->nullable();
            $table->string('color', 255)->nullable();
            $table->integer('offduty_day')->nullable();
            $table->integer('ot_calculate_type')->nullable();
            $table->time('ot_calculate_time')->nullable();
            $table->integer('off_next_day')->default(0)->comment('yes=1 and no=0');
            $table->integer('on_next_day');
            $table->double('max_normal_ot_hrs')->nullable();
            $table->double('max_double_ot_hrs')->nullable();
            $table->double('weekend_max_normal_ot_hrs')->nullable();
            $table->double('weekend_max_double_ot_hrs')->nullable();
            $table->integer('deleted');
            $table->integer('status')->default(0);
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shift_types');
    }
};