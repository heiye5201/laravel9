<?php

namespace App\Models;

use App\Traits\TimeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cash extends Model
{
    use HasFactory, SoftDeletes, TimeTrait;

    protected $guarded = [];

    protected $hidden = [
        'deleted_at',
    ];
}
