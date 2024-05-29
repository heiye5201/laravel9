<?php

namespace App\Models;

class OrderSeller extends BaseModel
{

    protected $table = "orders";


    protected $dates = ['pay_time','delivery_time','receipt_time','comment_time'];

    public function order_goods()
    {
        return $this->hasMany('App\Models\OrderGoods', 'order_id', 'id');
    }

    // 获取店铺信息
    public function store()
    {
        return $this->hasOne('App\Models\Store', 'id', 'store_id');
    }

    // 获取店铺信息
    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    // 获取售后
    public function refund()
    {
        return $this->hasOne('App\Models\Refund', 'order_id', 'id');
    }

    // // 获取分销日志
    public function distribution(){
        return $this->hasMany('App\Models\DistributionLog','order_id','id');
    }
}
