<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Certificate extends Model
{
    protected $connection = 'mongodb';

    protected $fillable = ['title_ru', 'title_en', 'issuer', 'year', 'image', 'description_ru', 'description_en', 'sort_order'];

    protected $casts = ['year' => 'integer', 'sort_order' => 'integer'];
}
