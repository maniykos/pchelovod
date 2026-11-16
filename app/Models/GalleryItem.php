<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class GalleryItem extends Model
{
    protected $connection = 'mongodb';

    protected $fillable = ['title_ru', 'title_en', 'image', 'media_type', 'mime_type', 'alt_ru', 'alt_en', 'sort_order', 'is_published'];

    protected $casts = ['sort_order' => 'integer', 'is_published' => 'boolean'];
}
