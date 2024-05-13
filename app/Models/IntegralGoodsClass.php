<?php

namespace App\Models;

use App\Traits\TimeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IntegralGoodsClass extends Model
{
    use HasFactory, SoftDeletes, TimeTrait;

    protected $fillable = [
        'name'
    ];

    protected $hidden = [
        'deleted_at',
    ];
}
