<?php
// app/Models/ContactInfo.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactInfo extends Model
{
    protected $fillable = [
        'email',
        'phone',
        'address',
        'days',
        'time',
        'facebook_url',
        'instagram_url',
        'twitter_url',
        'youtube_url',
    ];
}

