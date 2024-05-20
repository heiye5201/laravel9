<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/14 21:39
 * description:
 */
namespace App\Http\Resources\Seller;

use Illuminate\Http\Resources\Json\JsonResource;

class GoodsResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'goods_verify' => $this->goods_verify,
            'goods_stock' => $this->goods_stock,
            'goods_status' => $this->goods_status,
            'goods_sale' => $this->goods_sale,
            'goods_price' => $this->goods_price,
            'goods_no' => $this->goods_no,
            'goods_name' => $this->goods_name,
            'goods_master_image' => $this->goods_master_image,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'class_name' => $this->goods_class->name ?? '',
            'brand_name' => $this->goods_brand->name ?? '',
        ];
    }
}