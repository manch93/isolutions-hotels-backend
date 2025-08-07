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
        Schema::table('feature_items', function (Blueprint $table) {
            // Drop foreign key constraint first
            $table->dropForeign(['feature_category_id']);
            
            // Rename the column from feature_category_id to content_id
            $table->renameColumn('feature_category_id', 'content_id');
        });

        // Add foreign key constraint to the renamed column
        Schema::table('feature_items', function (Blueprint $table) {
            $table->foreign('content_id')
                ->references('id')
                ->on('contents')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('feature_items', function (Blueprint $table) {
            // Drop foreign key constraint
            $table->dropForeign(['content_id']);
            
            // Rename the column back from content_id to feature_category_id
            $table->renameColumn('content_id', 'feature_category_id');
        });

        // Add back the original foreign key constraint
        Schema::table('feature_items', function (Blueprint $table) {
            $table->foreign('feature_category_id')
                ->references('id')
                ->on('feature_categories')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }
};
