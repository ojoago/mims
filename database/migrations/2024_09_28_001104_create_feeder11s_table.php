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
        Schema::create('feeder11s', function (Blueprint $table) {
            $table->id();
            // $table->string('zone_pid')->nullable();
            $table->string('state_id');
            $table->string('zone_pid');
            $table->string('feeder_33_pid')->nullable();
            $table->foreign('feeder_33_pid')->references('pid')->on('feeder33s')->onDelete('cascade');
            $table->string('name');
            $table->string('pid')->unique();
            $table->string('creator')->nullable();
            $table->foreign('creator')->references('pid')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feeder11s');
    }
};
