<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/16 22:40
 * description:
 */
namespace App\Http\Resources\Home;

use Illuminate\Http\Resources\Json\ResourceCollection;

class DistributionLogCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data'=>$this->collection->map(function ($item) {
                return [
                    'id'                        =>  $item->id,
                    'name'                      =>  $item->name,
                    'store_name'                =>  $item->store->store_name,
                    'nickname'                  =>  $item->user->nickname,
                    'order_no'                  =>  $item->order->order_no,
                    'goods_price'               =>  $item->order_goods->total_price,
                    'lev'                       =>  $item->lev,
                    'money'                     =>  $item->money,
                    'commission'                =>  $item->commission,
                    'status'                    =>  $item->status,
                    'created_at'                =>  $item->created_at->format('Y-m-d H:i:s'),
                ];
            }),
            'total'=>$this->total(), // 数据总数
            'last_page'=>$this->lastPage(), // 最后页面
            'per_page'=>$this->perPage(), // 每页数量
            'current_page'=>$this->currentPage(), // 当前页码
        ];
    }
}

