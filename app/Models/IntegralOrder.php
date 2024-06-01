<?php

namespace App\Models;

class IntegralOrder extends BaseModel
{

    public function order_goods()
    {
        return $this->hasMany('App\Models\IntegralOrderGoods', 'order_id', 'id');
    }
}
