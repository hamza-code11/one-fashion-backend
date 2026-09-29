<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_id')
                ->constrained('products')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->unsignedTinyInteger('rating');

            $table->text('review')->nullable();

            $table->timestamps();

            $table->index('product_id');
            $table->index('user_id');

            $table->unique([
                'product_id',
                'user_id',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
