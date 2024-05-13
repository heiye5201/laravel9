<?php

namespace App\Models;

use App\Traits\TimeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SmsLog extends Model
{
    use HasFactory, SoftDeletes, TimeTrait;

    protected $fillable = [
        'phone',
        'name',
        'content',
        'status',
        'error_msg',
        'ip',
    ];

    protected $hidden = [
        'deleted_at',
    ];
}
