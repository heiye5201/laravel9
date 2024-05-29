<?php

namespace App\Models;

use App\Traits\TimeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BaseModel extends Model
{
    use HasFactory;

    use SoftDeletes, TimeTrait;

    protected $guarded = [];

    protected $hidden = [
        'deleted_at',
    ];

    public function scopeTitle($query, $text)
    {
        return $query->where(function ($query) use ($text) {
            $query->where('title', 'like', '%' . str_replace(['%', '_'], ['\\%', '\\_'], $text) . '%');
        });
    }
}
