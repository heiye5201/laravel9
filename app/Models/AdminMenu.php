<?php

namespace App\Models;

use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class AdminMenu.
 *
 * @package namespace App\Models;
 */
class AdminMenu extends BaseModel implements Transformable
{
    use TransformableTrait;

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

    public function hasChildren()
    {
        return $this->hasOne('App\Models\AdminMenu', 'pid', 'id');
    }
}
