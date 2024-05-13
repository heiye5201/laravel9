<?php

namespace App\Models;

use App\Traits\TimeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMenu extends Model
{
    use HasFactory, TimeTrait;


    public function hasChildren()
    {
        return $this->hasOne('App\Models\UserMenu', 'pid', 'id');
    }
}
