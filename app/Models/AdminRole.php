<?php

namespace App\Models;

class AdminRole extends BaseModel
{

    protected $fillable = [
        'name',
        'belong_id'
    ];

    public function permissions()
    {
        return $this->belongsToMany('App\Models\AdminPermission', 'admin_to_permissions', 'role_id', 'permission_id');
    }

    public function menus()
    {
        return $this->belongsToMany('App\Models\AdminMenu', 'admin_to_menus', 'role_id', 'menu_id');
    }
}
