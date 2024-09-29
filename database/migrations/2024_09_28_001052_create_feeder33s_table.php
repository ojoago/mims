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
        Schema::create('feeder33s', function (Blueprint $table) {
            $table->id();
            $table->string('region_pid')->nullable();
            $table->foreign('region_pid')->references('pid')->on('regions')->onDelete('cascade');
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
        Schema::dropIfExists('feeder33s');
    }
};
