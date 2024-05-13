<?php

namespace App\Models;

use App\Traits\TimeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdvSpace extends Model
{
    use HasFactory, SoftDeletes, TimeTrait;

    protected $fillable = [
        'belong_id',
        'local_type',
        'name',
        'width',
        'height',
    ];

    protected $hidden = [
        'deleted_at',
    ];
}
