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
        Schema::create('disco_lists', function (Blueprint $table) {
            $table->id();
            $table->string('region_pid')->nullable();
            $table->foreign('region_pid')->references('pid')->on('regions')->onDelete('cascade');
            $table->string('pid')->unique();
            $table->string('account_number');
            $table->string('customer_names');
            $table->string('phase')->nullable();
            $table->string('gsm')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->string('disco_code', 20);
            $table->tinyInteger('installation_status')->comment('0:no_metered,1:metered')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disco_lists');
    }
};
