<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class OrderRequest extends Model
{
    protected $connection = 'mongodb';

    protected $fillable = ['product_id', 'product_title', 'name', 'phone', 'message', 'status', 'locale'];
}
