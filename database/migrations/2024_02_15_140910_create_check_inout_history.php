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
        Schema::create('check_inout_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('hotel_id');
            $table->foreignId('room_id');
            $table->boolean('is_check_in')->nullable();
            $table->boolean('is_check_out')->nullable();
            $table->string('guest_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('check_inout_history');
    }
};
