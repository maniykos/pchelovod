<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Product extends Model
{
    protected $connection = 'mongodb';

    protected $fillable = [
        'title_ru', 'title_en', 'slug', 'description_ru', 'description_en',
        'price', 'unit', 'image', 'gallery', 'is_featured', 'is_published', 'sort_order',
    ];

    protected $casts = [
        'price' => 'float',
        'gallery' => 'array',
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
        'sort_order' => 'integer',
    ];
}
