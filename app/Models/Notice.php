<?php

namespace App\Models;

use App\Traits\TimeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notice extends Model
{
    use HasFactory, SoftDeletes, TimeTrait;

    protected $fillable = [
        'belong_id',
        'tag',
        'name',
        'content',
        'is_type',
        'is_send',
    ];

    protected $hidden = [
        'deleted_at',
    ];
}