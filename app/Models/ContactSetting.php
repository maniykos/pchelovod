<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class ContactSetting extends Model
{
    protected $connection = 'mongodb';

    protected $fillable = ['phone', 'telegram', 'max_username', 'email', 'address_ru', 'address_en', 'working_hours_ru', 'working_hours_en'];
}
