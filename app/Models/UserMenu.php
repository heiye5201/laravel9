<?php

namespace App\Models;

class UserMenu extends BaseModel
{
    public function hasChildren()
    {
        return $this->hasOne('App\Models\UserMenu', 'pid', 'id');
    }
}
