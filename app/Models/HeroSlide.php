<?php
// app/Models/HeroSlide.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroSlide extends Model
{
    protected $fillable = [
        'label',
        'heading',
        'description',
        'primary_cta_label',
        'primary_cta_href',
        'secondary_cta_label',
        'secondary_cta_href',
        'image',
    ];

    /**
     * Frontend ko headingLines array ke roop mein bhejein
     */
    protected $appends = ['heading_lines'];

    public function getHeadingLinesAttribute(): array
    {
        return array_values(
            array_filter(
                array_map('trim', explode("\n", $this->heading ?? '')),
                fn ($line) => $line !== ''
            )
        );
    }
}
