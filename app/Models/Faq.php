<?php
// app/Models/Faq.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $fillable = [
        'eyebrow',
        'heading',
        'description',
        'items',
    ];

    protected $casts = [
        'items' => 'array',
    ];
}
