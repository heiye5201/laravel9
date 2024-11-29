<?php
/**
 * autor      : jiweijian
 * createTime : 2024/11/28 17:31
 * description:
 */
namespace App\Services\Goods\Contracts\Accessors;

interface GoodsAccessor
{

    /**
     * 获取商品品牌Id
     * @return string
     */
    public function getBrandId(): int;

    /**
     * 获取商品名称
     * @return array
     */
    public function getGoodsName(): string;

    /**
     * 获取商品副标题
     * @return string
     */
    public function getGoodsSubname(): string;

    /**
     * 获取商品编号
     * @return float
     */
    public function getGoodsNo(): string;

    /**
     * 获取价格
     * @return float
     */
    public function getGoodsPrice(): float;

    /**
     * 获取商品市场价格
     * @return float
     */
    public function getGoodsMarketPrice() : float;

    /**
     * 获取商品库存
     * @return int
     */
    public function getGoodsStock() : int;

    /**
     * 获取商品销量
     * @return int
     */
    public function getGoodsSale() : int;

}