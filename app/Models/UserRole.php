<?php

namespace App\Models;

class UserRole extends BaseModel
{
    public function permissions()
    {
        return $this->belongsToMany('App\Models\UserPermission', 'user_to_permissions', 'role_id', 'permission_id');
    }

    public function menus()
    {
        return $this->belongsToMany('App\Models\UserMenu', 'user_to_menus', 'role_id', 'menu_id');
    }
}
