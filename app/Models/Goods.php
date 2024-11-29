<?php

namespace App\Models;


use App\Services\Goods\Contracts\GoodsEntity;

class Goods extends BaseModel implements GoodsEntity
{

    use \App\Models\Traits\GoodsEntity;

    public function goods_class()
    {
        return $this->hasOne('App\Models\GoodsClass', 'id', 'class_id')->withTrashed();
    }

    public function goods_brand()
    {
        return $this->hasOne('App\Models\GoodsBrand', 'id', 'brand_id')->withTrashed();
    }

    public function goods_skus()
    {
        return $this->hasMany('App\Models\GoodsSku', 'goods_id', 'id')->withTrashed();
    }

    public function goods_sku()
    {
        return $this->hasOne('App\Models\GoodsSku', 'goods_id', 'id');
    }

    public function order_comment()
    {
        return $this->hasMany('App\Models\OrderComment', 'goods_id', 'id');
    }

    public function order_goods()
    {
        return $this->hasMany('App\Models\OrderGoods', 'goods_id', 'id');
    }

    public function store()
    {
        return $this->hasOne('App\Models\Store', 'id', 'store_id')->withTrashed();
    }

    public function seckill()
    {
        return $this->hasOne('App\Models\Seckill', 'goods_id', 'id')->withTrashed();
    }

    // 获取拼团
    public function collective()
    {
        return $this->hasOne('App\Models\Collective', 'goods_id', 'id')->withTrashed();
    }

    // 获取分销ID
    public function distribution()
    {
        return $this->hasOne('App\Models\Distribution', 'goods_id', 'id')->withTrashed();
    }
}
