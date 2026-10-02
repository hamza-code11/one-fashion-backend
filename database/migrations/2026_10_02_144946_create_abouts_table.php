<?php
// database/migrations/xxxx_xx_xx_create_abouts_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('abouts', function (Blueprint $table) {
            $table->id();

            /* ---------- HERO ---------- */
            $table->string('hero_eyebrow', 100);
            $table->string('hero_heading', 255);
            $table->string('hero_subheading', 255);

            /* ---------- STORY ---------- */
            $table->string('story_eyebrow', 100);
            $table->string('story_heading', 255);
            $table->text('story_paragraphs');           // newline-separated
            $table->string('story_image', 500);

            /* ---------- PHILOSOPHY ---------- */
            $table->string('philosophy_eyebrow', 100);
            $table->string('philosophy_heading', 255);
            $table->text('philosophy_description');
            $table->json('philosophy_values');          // [{title, description}, ...]

            /* ---------- QUALITY ---------- */
            $table->string('quality_eyebrow', 100);
            $table->string('quality_heading', 255);
            $table->text('quality_description');
            $table->string('quality_image', 500);

            /* ---------- QUALITY STATS ---------- */
            $table->json('quality_stats');              // [{value, label}, ...]

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('abouts');
    }
};
