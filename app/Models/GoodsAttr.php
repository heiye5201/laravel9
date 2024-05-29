<?php

namespace App\Models;

class GoodsAttr extends BaseModel
{

    protected $fillable = [
        'store_id',
        'name',
    ];

    public function specs()
    {
        return $this->hasMany('App\Models\GoodsSpecs', 'attr_id', 'id');
    }
}
