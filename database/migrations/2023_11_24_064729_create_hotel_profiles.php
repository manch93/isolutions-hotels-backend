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
        Schema::create('hotel_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')->constrained();
            $table->string('logo_color')->nullable();
            $table->string('logo_white')->nullable();
            $table->string('logo_black')->nullable();
            $table->string('primary_color')->nullable();
            $table->text('description')->nullable();
            $table->string('main_photo')->nullable();
            $table->string('background_photo')->nullable();
            $table->string('intro_video')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotel_profiles');
    }
};
