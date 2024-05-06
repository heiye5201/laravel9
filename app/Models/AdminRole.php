<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminRole extends Model
{
    use HasFactory;


    public function permissions()
    {
        return $this->belongsToMany('App\Models\AdminPermission', 'admin_to_permissions', 'role_id', 'permission_id');
    }

    public function menus()
    {
        return $this->belongsToMany('App\Models\AdminMenu', 'admin_to_menus', 'role_id', 'menu_id');
    }
}
