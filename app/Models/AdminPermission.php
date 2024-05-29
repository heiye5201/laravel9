<?php

namespace App\Models;

class AdminPermission extends BaseModel
{

    protected $fillable = [
        'pid',
        'name',
        'apis',
        'content',
    ];

    public $appends = [
        'group_name'
    ];

    public function permission_groups()
    {
        return $this->hasOne('App\Models\AdminPermissionGroup', 'id', 'pid');
    }

    public function getGroupNameAttribute()
    {
        return $this->permission_groups->name ?? '';
    }

}
