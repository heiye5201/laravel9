<?php

namespace App\Models;

class Refund extends BaseModel
{
    public function order()
    {
        return $this->hasOne('App\Models\Order', 'id', 'order_id');
    }
}
