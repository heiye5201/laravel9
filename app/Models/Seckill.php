<?php

namespace App\Models;

class Seckill extends BaseModel
{
    public function goods()
    {
        return $this->hasOne('App\Models\Goods', 'id', 'goods_id')->withTrashed();
    }
}
