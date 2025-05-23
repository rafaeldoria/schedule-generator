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
        Schema::create('employee_settings', function (Blueprint $table) {
            $table->id();
            $table->string('duration');
            $table->string('start_time');
            $table->string('end_time');
            $table->boolean('saturday_off')->nullable();
            $table->string('close_days')->nullable();
            $table->string('interval')->default(0)->comment('in minutes');
            $table->unsignedBigInteger('employee_id')->unique();
            $table->foreign('employee_id')->references('id')->on('employees');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_settings');
    }
};
