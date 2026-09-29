<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->foreignId('brand_id')
                ->constrained('brands')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('category_id')
                ->constrained('categories')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->string('name', 150);
            $table->string('slug', 180)->unique();

            $table->text('description')->nullable();

            $table->decimal('price', 10, 2);
            $table->decimal('old_price', 10, 2)->nullable();

            $table->string('gender', 20);

            $table->enum('badge', [
                'NEW',
                'SALE',
                'HOT',
            ])->nullable();

            $table->enum('status', [
                'draft',
                'published',
            ])->default('draft');

            $table->enum('stock_status', [
                'in_stock',
                'out_of_stock',
            ])->default('in_stock');

            $table->timestamps();

            $table->index('status');
            $table->index('stock_status');
            $table->index('gender');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
