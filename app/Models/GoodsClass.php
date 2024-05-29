<?php

namespace App\Models;

class GoodsClass extends BaseModel
{

    protected $fillable = [
        'pid',
        'thumb',
        'name',
        'simple_name',
        'is_sort'
    ];

    public function hasChildren()
    {
        return $this->hasOne('App\Models\GoodsClass', 'pid', 'id');
    }

    public function children()
    {
        return $this->hasMany('App\Models\GoodsClass', 'pid', 'id');
    }
}
