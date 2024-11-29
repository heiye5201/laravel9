<?php
/**
 * autor      : jiweijian
 * createTime : 2024/11/28 17:48
 * description:
 */
namespace App\Models\Traits\Mutators;

trait GoodsMutator
{

    /**
     * 设置品牌id
     * @param int $brandId
     * @return $this
     */
    public function setBrandId(int $brandId)
    {
        $this->attributes['brand_id'] = $brandId;
        return $this;
    }

    /**
     * 设置商品名称
     * @param string $name
     * @return $this
     */
    public function setGoodsName(string $name)
    {
        $this->attributes['goods_name'] = $name;
        return $this;
    }

    /**
     * 设置商品副名称
     * @param string $goodsSubname
     * @return $this
     */
    public function setGoodsSubname(string $goodsSubname)
    {
        $this->attributes['goods_subname'] = $goodsSubname;
        return $this;
    }

    /**
     * 设置商品编号
     * @param string $goodsNo
     * @return $this
     */
    public function setGoodsNo(string $goodsNo)
    {
        $this->attributes['goods_no'] = $goodsNo;
        return $this;
    }

    /**
     * 设置价格
     * @param float $price
     * @return $this
     */
    public function setGoodsPrice(float $price)
    {
        $this->attributes['goods_price'] = $price;
        return $this;
    }

    /**
     * 设置商品市场价格
     * @param float $price
     * @return $this
     */
    public function setGoodsMarketPrice(float $price)
    {
        $this->attributes['goods_market_price'] = $price;
        return $this;
    }

    /**
     * 设置商品库存
     * @param int $stock
     * @return $this
     */
    public function setGoodsStock(int $stock)
    {
        $this->attributes['goods_stock'] = $stock;
        return $this;
    }

    /**
     * 设置商品销量
     * @param int $sale
     * @return $this
     */
    public function setGoodsSale(int $sale)
    {
        $this->attributes['goods_sale'] = $sale;
        return $this;
    }
}