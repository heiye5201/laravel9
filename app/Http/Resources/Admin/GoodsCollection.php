<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/18 09:40
 * description:
 */
namespace App\Http\Resources\Admin;

use App\Models\GoodsClass;
use App\Services\ToolService;
use Illuminate\Http\Resources\Json\ResourceCollection;

class GoodsCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'data'=>$this->collection->map(function ($item) {
                $tool = new ToolService();
                $goods_price = $item->goods_price;
                $goods_stock = $item->goods_stock;
                // 判断是否存在sku
                if (isset($item->goods_skus) && count($item->goods_skus)>0) {
                    $goods_stock = 0;
                    foreach ($item->goods_skus as $v) {
                        $goods_stock += $v['goods_stock'];
                    }
                    if (count($item->goods_skus)>1) {
                        $goods_price = $item->goods_skus[0]['goods_price'].' ~ '.$item->goods_skus[count($item->goods_skus)-1]['goods_price'];
                    } else {
                        $goods_price = $item->goods_skus[0]['goods_price'];
                    }
                }
                return [
                    'id'                    =>  $item->id,
                    'goods_name'            =>  $item->goods_name,
                    'goods_price'           =>  $goods_price,
                    'goods_stock'           =>  $goods_stock,
                    'goods_sale'            =>  $item->goods_sale,
                    'goods_master_image'    =>  $tool->thumb($item->goods_master_image, 150),
                    'brand_name'            =>  $item->goods_brand->name??'',
                    'class_name'            =>  $item->goods_class->name??'',
                    'goods_no'              =>  $item->goods_no,
                    'goods_status'          =>  $item->goods_status,
                    'goods_verify'          =>  $item->goods_verify,
                    'created_at'            =>  $item->created_at->format('Y-m-d H:i:s'),
                    'updated_at'            =>  $item->updated_at->format('Y-m-d H:i:s'),
                ];
            }),
            'total'=>$this->total(), // 数据总数
            'last_page'=>$this->lastPage(), // 最后页面
            'per_page'=>$this->perPage(), // 每页数量
            'current_page'=>$this->currentPage(), // 当前页码
        ];
    }
}