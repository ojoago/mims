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
        Schema::create('item_quantities', function (Blueprint $table) {
            $table->id();
            $table->string('region_pid');
            $table->foreign('region_pid')->references('pid')->on('regions')->onDelete('cascade');
            $table->string('pid')->unique();
            $table->string('item_pid');
            $table->foreign('item_pid')->references('pid')->on('items')->onDelete('cascade');
            $table->float('quantity', 20, 2);
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
        Schema::dropIfExists('items_quantities');
    }
};
