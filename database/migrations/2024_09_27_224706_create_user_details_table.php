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
        Schema::create('user_details', function (Blueprint $table) {
            $table->id();
            $table->string('user_pid');
            $table->foreign('user_pid')->references('pid')->on('users')->onDelete('cascade');
            $table->string('staff_id');
            $table->string('gsm');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('othername')->nullable();
            $table->string('marital_status', 20);
            $table->string('gender', 20);
            $table->string('religion', 20);
            $table->string('pob')->comment('place of birth');
            $table->string('dob', 20)->comment('date of birth');
            $table->string('state_of_origin')->nullable();
            $table->string('lga_of_origin')->nullable();
            $table->string('state_of_residence')->nullable();
            $table->string('lga_of_residence')->nullable();
            $table->longText('address')->nullable();
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
        Schema::dropIfExists('user_details');
    }
};
