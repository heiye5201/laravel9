<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasEvents;

class ArticleMenu extends BaseModel
{
    use HasEvents;

    protected $fillable = [
        'belong_id',
        'pid',
        'name',
        'is_sort',
    ];
}
