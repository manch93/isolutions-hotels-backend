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
        Schema::table('hotel_profiles', function (Blueprint $table) {
            $table->string('instagram_username')->nullable()->after('welcome_text');
            $table->string('facebook_username')->nullable()->after('instagram_username');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hotel_profiles', function (Blueprint $table) {
            $table->dropColumn(['instagram_username', 'facebook_username']);
        });
    }
};
