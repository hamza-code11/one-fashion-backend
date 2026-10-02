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
        Schema::create('instagram', function (Blueprint $table) {
            $table->id();

            // 'settings' → channel info (handle + profile_url)
            // 'post'     → instagram post/reel (url OR image)
            $table->enum('type', ['settings', 'post']);

            // For type = 'settings'
            $table->string('handle', 100)->nullable();
            $table->string('profile_url', 500)->nullable();

            // For type = 'post' — EITHER url OR image
            // url   → Instagram post/reel link (user copies from app)
            // image → uploaded thumbnail (optional fallback)
            $table->string('url', 500)->nullable();
            $table->string('image', 500)->nullable();

            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instagram');
    }
};
