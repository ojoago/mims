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
        Schema::create('replacements', function (Blueprint $table) {
            $table->id();
            $table->string('meter_pid');
            $table->foreign('meter_pid')->references('pid')->on('installations')->onDelete('cascade');;
            $table->string('old_meter_number');
            $table->string('old_seal');
            $table->string('old_installer');
            $table->string('date',20);
            $table->string('creator');
            $table->foreign('creator')->references('pid')->on('users')->onDelete('cascade');;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('replacements');
    }
};
