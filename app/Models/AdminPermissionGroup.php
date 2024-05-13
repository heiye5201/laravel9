<?php

namespace App\Models;

use App\Traits\TimeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminPermissionGroup extends Model
{
    use HasFactory, TimeTrait, SoftDeletes;

    protected $fillable = [
        'id',
        'name',
        'content'
    ];

    protected $hidden = [
        'deleted_at',
    ];

}
