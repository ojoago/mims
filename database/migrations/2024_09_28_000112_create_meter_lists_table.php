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
        Schema::create('meter_lists', function (Blueprint $table) {
            $table->id();
            $table->string('region_pid')->nullable();
            $table->foreign('region_pid')->references('pid')->on('regions')->onDelete('cascade');
            $table->string('pid')->unique();
            $table->string('meter_number')->unique();
            $table->tinyInteger('status')->default(1)->comment('1:in store,2:taken out,3:installed,4:faulty,5:replaced');
            $table->string('phase');
            $table->string('type')->nullable();
            $table->string('brand')->nullable();
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
        Schema::dropIfExists('meter_lists');
    }
};
