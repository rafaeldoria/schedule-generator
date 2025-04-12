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
        Schema::create('schedule_details', function (Blueprint $table) {
            $table->id();
            $table->string('date');
            $table->string('start_time');
            $table->string('end_time');
            $table->tinyInteger('status')->default(0)->comment('0 => OPEN, 1 => SCHEDULED, 2 => CLOSED');
            $table->unsignedBigInteger('schedule_id')->unique();
            $table->foreign('schedule_id')->references('id')->on('schedules');
            $table->unsignedBigInteger('customer_id')->unique()->nullable();
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule_details');
    }
};
