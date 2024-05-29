<?php

namespace App\Models;

class Notice extends BaseModel
{
    protected $fillable = [
        'belong_id',
        'tag',
        'name',
        'content',
        'is_type',
        'is_send',
    ];
}
