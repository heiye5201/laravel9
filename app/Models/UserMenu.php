<?php

namespace App\Models;

use App\Traits\TimeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserMenu extends Model
{
    use HasFactory, SoftDeletes, TimeTrait;

    public function hasChildren()
    {
        return $this->hasOne('App\Models\UserMenu', 'pid', 'id');
    }

    protected $hidden = [
        'deleted_at',
    ];
}
