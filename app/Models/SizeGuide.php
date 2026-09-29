<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SizeGuide extends Model
{
    protected $fillable = [
        'size',
        'height',
        'weight',
        'chest',
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(
            Product::class,
            'product_size_guide'
        );
    }
}