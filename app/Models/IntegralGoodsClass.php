<?php

namespace App\Models;

class IntegralGoodsClass extends BaseModel
{

    protected $fillable = [
        'name'
    ];

    public function integral_goods()
    {
        return $this->hasMany('App\Models\IntegralGoods', 'cid', 'id');
    }
}
