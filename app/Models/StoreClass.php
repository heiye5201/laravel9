<?php

namespace App\Models;

use App\Traits\TimeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StoreClass extends Model
{
    use HasFactory, SoftDeletes, TimeTrait;

    protected $fillable = [
        'store_id',
        'class_id',
        'class_name',
    ];

    protected $hidden = [
        'deleted_at',
    ];
}
