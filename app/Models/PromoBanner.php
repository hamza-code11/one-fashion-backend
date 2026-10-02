<?php
// app/Models/PromoBanner.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromoBanner extends Model
{
    protected $fillable = [
        'eyebrow',
        'heading',
        'description',
        'cta_label',
        'cta_href',
        'image',
    ];
}

