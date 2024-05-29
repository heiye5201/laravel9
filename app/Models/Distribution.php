<?php

namespace App\Models;

class Distribution extends BaseModel
{
    public function goods()
    {
        return $this->hasOne('App\Models\Goods', 'id', 'goods_id')->withTrashed();
    }
}
