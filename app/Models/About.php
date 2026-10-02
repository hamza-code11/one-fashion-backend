<?php
// app/Models/About.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    protected $fillable = [
        'hero_eyebrow',
        'hero_heading',
        'hero_subheading',
        'story_eyebrow',
        'story_heading',
        'story_paragraphs',
        'story_image',
        'philosophy_eyebrow',
        'philosophy_heading',
        'philosophy_description',
        'philosophy_values',
        'quality_eyebrow',
        'quality_heading',
        'quality_description',
        'quality_image',
        'quality_stats',
    ];

    protected $casts = [
        'philosophy_values' => 'array',
        'quality_stats'     => 'array',
    ];

    /* ---------- accessor: story_paragraphs as array ---------- */
    public function getStoryParagraphsArrayAttribute(): array
    {
        return array_values(
            array_filter(
                array_map('trim', explode("\n\n", $this->story_paragraphs ?? '')),
                fn ($p) => $p !== ''
            )
        );
    }

    protected $appends = ['story_paragraphs_array'];
}

