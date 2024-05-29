<?php

namespace App\Models;

class Cart extends BaseModel
{

    protected $guarded = [];


    public function goods()
    {
        return $this->hasOne('App\Models\Goods', 'id', 'goods_id')->withTrashed();
    }

    public function store()
    {
        return $this->hasOne('App\Models\Store', 'id', 'store_id')->withTrashed();
    }

    public function carts()
    {
        return $this->hasMany('App\Models\Cart', 'store_id', 'store_id');
    }

    public function goods_sku()
    {
        return $this->hasOne('App\Models\GoodsSku', 'id', 'sku_id');
    }
}
