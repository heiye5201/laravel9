<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/15 00:12
 * description:
 */
namespace App\Http\Resources\Seller;

use Illuminate\Http\Resources\Json\JsonResource;

class DistributionsResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'created_at' => $this->created_at,
            'lev_1' => $this->lev_1,
            'lev_2' => $this->lev_2,
            'lev_3' => $this->lev_3,
            'goods_name' => $this->goods->goods_name,
            'goods_master_image' => $this->goods->goods_master_image,
        ];
    }
}