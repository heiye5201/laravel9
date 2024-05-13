<?php

namespace App\Models;

use App\Traits\TimeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Adv extends Model
{
    use HasFactory, SoftDeletes, TimeTrait;

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

    protected $hidden = [
        'deleted_at',
    ];
}
