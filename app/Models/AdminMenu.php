<?php

namespace App\Models;

use App\Traits\TimeTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class AdminMenu.
 *
 * @package namespace App\Models;
 */
class AdminMenu extends Model implements Transformable
{
    use TransformableTrait, TimeTrait, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pid',
        'name',
        'ename',
        'icon',
        'apis',
        'view',
        'is_open',
        'content',
        'is_sort',
    ];


    protected $hidden = [
        'deleted_at',
    ];

    public function hasChildren()
    {
        return $this->hasOne('App\Models\AdminMenu', 'pid', 'id');
    }
}
