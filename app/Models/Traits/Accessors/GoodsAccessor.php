<?php
/**
 * autor      : jiweijian
 * createTime : 2024/11/28 17:48
 * description:
 */

namespace App\Models\Traits\Accessors;

trait GoodsAccessor
{
    /**
     * 获取商品品牌Id
     * @return string
     */
    public function getBrandId(): int
    {
        return $this->attributes['brand_id'];
    }

    /**
     * 获取商品名称
     * @return array
     */
    public function getGoodsName(): string
    {
        return $this->attributes['goods_name'];
    }

    /**
     * 获取商品副标题
     * @return string
     */
    public function getGoodsSubname(): string
    {
        return $this->attributes['goods_subname'];
    }

    /**
     * 获取商品编号
     * @return float
     */
    public function getGoodsNo(): string
    {
        return $this->attributes['goods_no'];
    }

    /**
     * 获取价格
     * @return float
     */
    public function getGoodsPrice(): float
    {
        return $this->attributes['goods_price'];
    }

    /**
     * 获取商品市场价格
     * @return float
     */
    public function getGoodsMarketPrice() : float
    {
        return $this->attributes['goods_market_price'];
    }

    /**
     * 获取商品库存
     * @return int
     */
    public function getGoodsStock() : int
    {
        return $this->attributes['goods_stock'];
    }

    /**
     * 获取商品销量
     * @return int
     */
    public function getGoodsSale() : int
    {
        return $this->attributes['goods_sale'];
    }
}