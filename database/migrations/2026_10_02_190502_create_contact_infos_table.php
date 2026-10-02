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
        Schema::create('contact_infos', function (Blueprint $table) {
            $table->id();

            // Contact details
            $table->string('email', 255);
            $table->string('phone', 50);
            $table->string('address', 255);

            // Opening hours
            $table->string('days', 100);       // e.g. "Monday – Saturday"
            $table->string('time', 100);       // e.g. "10:00am – 7:00pm"

            // Social links (4)
            $table->string('facebook_url', 500)->nullable();
            $table->string('instagram_url', 500)->nullable();
            $table->string('twitter_url', 500)->nullable();
            $table->string('youtube_url', 500)->nullable();

            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_infos');
    }
};
