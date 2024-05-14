<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/15 01:20
 * description:
 */
namespace App\Http\Resources\Seller;

use Illuminate\Http\Resources\Json\JsonResource;

class CollectiveResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'need' => $this->need,
            'store_id' => $this->store_id,
            'goods_id' => $this->goods_id,
            'discount' => $this->discount,
            'created_at' => $this->created_at,
            'goods_name' => $this->goods->goods_name,
            'goods_master_image' => $this->goods->goods_master_image,
        ];
    }
}
