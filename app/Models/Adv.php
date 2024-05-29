<?php

namespace App\Models;

class Adv extends BaseModel
{

    protected $fillable = [
        'belong_id',
        'pid',
        'name',
        'url',
        'image',
        'adv_start',
        'adv_end',
        'is_sort',
        'is_type',
        'status',
    ];
}
