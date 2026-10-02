<?php
// app/Models/StatItem.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatItem extends Model
{
    protected $fillable = [
        'value',
        'label',
    ];
}

