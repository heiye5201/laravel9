<?php

namespace App\Models;

class OrderGoods extends BaseModel
{

    public function distribution()
    {
        return $this->hasOne("App\Models\Distribution", "goods_id", 'goods_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, "id", 'user_id');
    }
}
