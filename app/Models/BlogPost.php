<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class BlogPost extends Model
{
    protected $connection = 'mongodb';

    protected $fillable = [
        'title_ru', 'title_en', 'slug', 'excerpt_ru', 'excerpt_en',
        'body_ru', 'body_en', 'image', 'published_at', 'is_published',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_published' => 'boolean',
    ];
}
