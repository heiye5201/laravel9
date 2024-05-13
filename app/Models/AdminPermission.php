<?php

namespace App\Models;

use App\Traits\TimeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminPermission extends Model
{
    use HasFactory, TimeTrait, SoftDeletes;

    protected $hidden = [
        'deleted_at',
    ];


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
