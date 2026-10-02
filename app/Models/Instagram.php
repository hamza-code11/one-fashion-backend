<?php
// app/Models/Instagram.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Instagram extends Model
{
    protected $table = 'instagram';

    protected $fillable = [
        'type',
        'handle',
        'profile_url',
        'url',
        'image',
    ];

    /* ---------- scopes ---------- */

    public function scopeSettings(Builder $query): Builder
    {
        return $query->where('type', 'settings');
    }

    public function scopePosts(Builder $query): Builder
    {
        return $query->where('type', 'post');
    }
}
