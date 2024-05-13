<?php

namespace App\Models;

use App\Traits\TimeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminRole extends Model
{
    use HasFactory, TimeTrait, SoftDeletes;

    protected $fillable = [
        'name',
        'belong_id'
    ];


    protected $hidden = [
        'deleted_at',
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
