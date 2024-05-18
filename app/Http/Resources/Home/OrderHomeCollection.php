<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/16 22:57
 * description:
 */
namespace App\Http\Resources\Home;

use App\Models\GoodsSku;
use App\Models\GoodsSpecs;
use App\Services\OrderService;
use Illuminate\Http\Resources\Json\ResourceCollection;

class OrderHomeCollection extends ResourceCollection
{
    public function toArray($request)
    {
        $orderService = new OrderService;
        return [
            'data'=>$this->collection->map(function ($item) use ($orderService) {

                return [
                    'id'                    =>  $item->id,
                    'order_no'              =>  $item->order_no,
                    'order_price'           =>  $item->order_price,
                    'total_price'           =>  $item->total_price,
                    'order_status'          =>  $item->order_status,
                    'apply_status'         =>  $item->apply_status,
                    'apply_status_cn'       =>  $orderService->getApplyStatus($item),
                    'order_status_cn'       =>  $orderService->getOrderStatusCn($item),
                    'store'                 =>  $item->store,
                    'refund_status'         =>  $item->refund_status,
                    'user'                  =>  $item->user,
                    'created_at'            =>  $item->created_at->format('Y-m-d H:i'),
                    'order_goods'           =>  $item->order_goods->map(function ($v) {
                        $goods_props = [];
                        $spec_id = GoodsSku::query()->where('id',$v->sku_id)->value('spec_id');
                        $spec_list = GoodsSpecs::query()->with(['attrs'])->whereIn('id',explode(',',$spec_id))->get();
                        foreach ($spec_list as $val) {
                            $specInfo = [
                                'group'=>['id'=>$val['attrs']['id'],'name'=>$val['attrs']['name']],
                                'value'=>['id'=>$val['id'],'name'=>$val['name']],
                            ];
                            $goods_props[] = $specInfo;
                        }
                        return [
                            'goods_image'=>getUrlByPath($v->goods_image),
                            'goods_name'=>$v->goods_name,
                            'sku_id' =>$v->sku_id,
                            'goods_price'=>$v->goods_price,
                            'sku_name'=>$v->sku_name,
                            'buy_num'=>$v->buy_num,
                            'total_price'=>$v->total_price,
                            'goods_props'=>$goods_props,
                        ];
                    }),
                ];
            }),
            'total'=>$this->total(), // 数据总数
            'per_page'=>$this->perPage(), // 每页数量
            'last_page'=>$this->lastPage(), // 每页数量
            'current_page'=>$this->currentPage(), // 当前页码
        ];
    }
}