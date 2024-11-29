<?php
/**
 * autor      : jiweijian
 * createTime : 2024/11/28 18:01
 * description:
 */

namespace App\Http\Resources\Goods;

use Illuminate\Http\Resources\Json\JsonResource;

class GoodsResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $item = $this->resource;
        return [
            'brand_id'           => $item->getBrandId(),
            'goods_name'   => $item->getGoodsName(),
            'goods_subname'   => $item->getGoodsSubname(),
            'goods_no'      => $item->getGoodsNo(),
            'goods_price'        => $item->getGoodsPrice(),
            'goods_market_price'   => $item->getGoodsMarketPrice(),
            'goods_stock' => $item->getGoodsStock(),
            'goods_sale'           => $item->getGoodsSale(),
        ];
    }
}