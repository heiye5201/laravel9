<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class AdminMenu.
 *
 * @package namespace App\Models;
 */
class AdminMenu extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];


    public function hasChildren()
    {
        return $this->hasOne('App\Models\AdminMenu', 'pid', 'id');
    }
}
