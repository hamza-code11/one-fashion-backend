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
        Schema::create('hero_slides', function (Blueprint $table) {
            $table->id();
            $table->string('label', 100);
            $table->text('heading');
            $table->text('description');

            $table->string('primary_cta_label', 100);
            $table->string('primary_cta_href', 255);

            $table->string('secondary_cta_label', 100);
            $table->string('secondary_cta_href', 255);

            $table->string('image', 500);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hero_slides');
    }
};
