<?php

namespace App\Models;

class OrderComment extends BaseModel
{

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function store()
    {
        return $this->hasOne('App\Models\Store', 'id', 'store_id')->withTrashed();
    }

    public function goods()
    {
        return $this->hasOne('App\Models\Goods', 'id', 'goods_id')->withTrashed();
    }
}
