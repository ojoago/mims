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
        Schema::create('request_items', function (Blueprint $table) {
            $table->id();
            $table->string('region_pid');
            $table->foreign('region_pid')->references('pid')->on('regions')->onDelete('cascade');
            $table->string('request_pid');
            $table->foreign('request_pid')->references('pid')->on('request_details')->onDelete('cascade');
            $table->string('item_pid');
            $table->foreign('item_pid')->references('pid')->on('items')->onDelete('cascade');
            $table->float('quantity',20,2);
            $table->float('quantity_supplied',20,2)->nullable();
            $table->float('quantity_returned',20,2)->nullable();
            // $table->float('quantity_returned',20,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_items');
    }
};
