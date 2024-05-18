<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/18 22:24
 * description:
 */
namespace App\Http\Resources;

use App\Models\GoodsSku;
use App\Models\GoodsSpecs;
use App\Services\OrderService;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{

    public function toArray($request)
    {
        $orderService = new OrderService();
        return [
            'id'                    =>  $this->id,
            'order_image'           =>  $this->order_image,
            'order_name'            =>  $this->order_name,
            'store_name'            =>  $this->store->store_name,
            'buyer_name'            =>  $this->user->nickname ?? '',
            'order_no'              =>  $this->order_no,
            'refund_id'             =>  empty($this->refund) ? 0 : $this->refund->id ?? '',
            'receive_name'          =>  $this->receive_name,
            'receive_tel'           =>  $this->receive_tel,
            'receive_area'          =>  $this->receive_area,
            'receive_address'       =>  $this->receive_address,
            'payment_name'          =>  $this->payment_name,
            'payment_name_cn'       =>  $orderService->getOrderPayMentCn($this->payment_name),
            'delivery_no'           =>  $this->delivery_no,
            'delivery_code'         =>  $this->delivery_code,
            'total_price'           =>  $this->total_price,
            'apply_status'         =>   $this->apply_status,
            'apply_status_cn'       =>  $orderService->getApplyStatus($this),
            'order_price'           =>  $this->order_price,
            'freight_money'         =>  $this->freight_money,
            'coupon_money'          =>  $this->coupon_money,
            'remark'                =>  $this->remark,
            'pay_time'              =>  $this->pay_time,
            'created_at'            =>  $this->created_at->format('Y-m-d H:i:s'),
            'order_status'          =>  $this->order_status,
            'order_status_cn'       =>  $orderService->getOrderStatusCn($this),
            'order_goods'           =>  $this->order_goods->map(function ($q) {
                $goods_props = [];
                $spec_id = GoodsSku::query()->where('id',$q->sku_id)->value('spec_id');
                $spec_list = GoodsSpecs::query()->with(['attrs'])->whereIn('id',explode(',',$spec_id))->get();
                foreach ($spec_list as $val) {
                    $specInfo = [
                        'group'=>['id'=>$val['attrs']['id'],'name'=>$val['attrs']['name']],
                        'value'=>['id'=>$val['id'],'name'=>$val['name']],
                    ];
                    $goods_props[] = $specInfo;
                }
                return [
                    'goods_id' => $q->goods_id,
                    'goods_image' => getUrlByPath($q->goods_image),
                    'goods_name' => $q->goods_name,
                    'goods_price' => $q->goods_price,
                    'sku_name' => $q->sku_name,
                    'sku_id' => $q->sku_id,
                    'buy_num' => $q->buy_num,
                    'goods_props'=>$goods_props,
                ];
            }),
        ];
    }
}

