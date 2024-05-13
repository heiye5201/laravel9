<?php

namespace App\Models;

use App\Traits\TimeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IntegralGoods extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'goods_status' => 'boolean',
        'is_recommend' => 'boolean',
        'created_at' => 'datetime:Y-m-d H:i',
    ];

    protected $fillable = [
        'cid',
        'goods_name',
        'goods_subname',
        'goods_price',
        'goods_market_price',
        'goods_stock',
        'goods_images',
        'goods_master_image',
        'goods_sale',
        'goods_status',
        'is_recommend',
        'goods_content',
        'goods_content_mobile',
    ];

    protected $hidden = [
        'deleted_at',
    ];

    public $appends = [
        'class_name'
    ];

    public function setGoodsStatusAttribute($value)
    {
        $this->attributes['goods_status'] = $value ? 1 : 0;
    }

    public function setIsRecommendAttribute($value)
    {
        $this->attributes['is_recommend'] = $value ? 1 : 0;
    }


    public function getGoodsImagesAttribute($value)
    {
        return explode(',', $value);
    }

    public function setGoodsImagesAttribute($value)
    {
        $this->attributes['goods_images'] = implode(',', $value);
    }


    public function class()
    {
        return $this->hasOne(IntegralGoodsClass::class, 'id', 'cid');
    }

    public function getClassNameAttribute()
    {
        return $this->class->name ?? '';
    }
}
