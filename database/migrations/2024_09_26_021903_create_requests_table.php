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
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->string('pid')->unique();
            $table->string('date',20);
            $table->text('note')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->string('region_pid');
            $table->foreign('region_pid')->references('pid')->on('regions')->onDelete('cascade');
            $table->string('requested_by');
            $table->foreign('requested_by')->references('pid')->on('users')->onDelete('cascade');
            $table->string('receiver');
            $table->foreign('receiver')->references('pid')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('requests');
    }
};
