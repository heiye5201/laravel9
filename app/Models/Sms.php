<?php

namespace App\Models;

class Sms extends BaseModel
{
    protected $fillable = [
        'name',
        'content',
        'description',
        'code'
    ];
}
