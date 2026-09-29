<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'brand_id',
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'old_price',
        'gender',
        'badge',
        'status',
        'stock_status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'old_price' => 'decimal:2',
    ];


    // Product belongs to one Brand
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }


    // Product belongs to one Category
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }


    // Product has many Images
    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }


    // Product has many Colors
    public function colors(): HasMany
    {
        return $this->hasMany(ProductColor::class);
    }


    // Product belongs to many Size Guides
    public function sizes(): BelongsToMany
    {
        return $this->belongsToMany(
            SizeGuide::class,
            'product_size_guide'
        );
    }


    // Product belongs to many Collections
    public function collections(): BelongsToMany
    {
        return $this->belongsToMany(
            Collection::class,
            'collection_product'
        );
    }


    // Product has many Ratings
    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
    }
}
