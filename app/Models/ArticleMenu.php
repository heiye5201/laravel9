<?php

namespace App\Models;

use App\Traits\TimeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArticleMenu extends Model
{
    use HasFactory, SoftDeletes, TimeTrait;

    protected $fillable = [
        'belong_id',
        'pid',
        'name',
        'is_sort',
    ];

    protected $hidden = [
        'deleted_at',
    ];
}
