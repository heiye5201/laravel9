<?php
/**
 * autor      : jiweijian
 * createTime : 2024/11/28 17:31
 * description:
 */
namespace App\Services\Goods\Contracts\Mutators;

interface GoodsMutator
{

    /**
     * 设置品牌id
     * @param int $brandId
     * @return $this
     */
    public function setBrandId(int $brandId);

    /**
     * 设置商品名称
     * @param string $name
     * @return $this
     */
    public function setGoodsName(string $name);

    /**
     * 设置商品副名称
     * @param string $goodsSubname
     * @return $this
     */
    public function setGoodsSubname(string $goodsSubname);

    /**
     * 设置商品编号
     * @param string $goodsNo
     * @return $this
     */
    public function setGoodsNo(string $goodsNo);

    /**
     * 设置价格
     * @param float $price
     * @return $this
     */
    public function setGoodsPrice(float $price);

    /**
     * 设置商品市场价格
     * @param float $price
     * @return $this
     */
    public function setGoodsMarketPrice(float $price);

    /**
     * 设置商品库存
     * @param int $stock
     * @return $this
     */
    public function setGoodsStock(int $stock);

    /**
     * 设置商品销量
     * @param int $sale
     * @return $this
     */
    public function setGoodsSale(int $sale);
}
