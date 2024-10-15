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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->string('account_number');
            $table->string('account_name')->nullable();
            $table->string('contact')->nullable();
            $table->string('state')->nullable();
            $table->string('region')->nullable();
            $table->string('feeder_33')->nullable();
            $table->string('feeder_11')->nullable();
            $table->string('dt_name')->nullable();
            $table->string('band')->nullable();
            $table->string('load')->nullable();
            $table->string('meter_type')->nullable();
            $table->string('address')->nullable();
            $table->string('connection_status')->nullable();
            $table->string('region_pid')->nullable();//region upload from
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
