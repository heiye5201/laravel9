<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/16 21:38
 * description:
 */

namespace App\Http\Resources\Home;

use App\Models\GoodsSku;
use App\Models\GoodsSpecs;
use App\Services\ToolService;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CartAppCollection extends ResourceCollection
{

    public $tool = null;

    public function toArray($request)
    {
        $this->tool = new ToolService();
        $data = $this->collection->map(function ($item) {
            $data = $item->carts->map(function ($cartItem) {
                // 是否存在sku
                $goods_image = empty($cartItem->goods) ? '' : $this->tool->thumb($cartItem->goods->goods_master_image, 150);
                $goods_price = $cartItem->goods->goods_price ?? '0.00';
                $sku_name = '-';
                $goods_props = [];
                $spec_list = [];
                if (!empty($cartItem->goods_sku)) {
                    $goods_price = $cartItem->goods_sku->goods_price ?? '0.00';
                    $sku_name = $cartItem->goods_sku->sku_name ?? '-';
                    $sku_id = $cartItem->goods_sku->id;
                    $spec_id = GoodsSku::query()->where('id', $sku_id)->value('spec_id');
                    $spec_list = GoodsSpecs::query()->with(['attrs'])->whereIn('id', explode(',', $spec_id))->get();
                    foreach ($spec_list as $val) {
                        $specInfo = [
                            'group' => ['id' => $val['attrs']['id'], 'name' => $val['attrs']['name']],
                            'value' => ['id' => $val['id'], 'name' => $val['name']],
                        ];
                        $goods_props[] = $specInfo;
                    }
                }
                return [
                    'cart_id' => $cartItem->id,
                    'goods_id' => $cartItem->goods_id,
                    'sku_id' => $cartItem->sku_id,
                    'goods_name' => $cartItem->goods->goods_name ?? '-',
                    'buy_num' => $cartItem->buy_num,
                    'goods_image' => getUrlByPath($goods_image),
                    'goods_price' => $goods_price,
                    'sku_name' => $sku_name,
                    'checked' => false,
                    'goods_props' => $goods_props,
                    'goods_sku' => $cartItem->goods_sku,
                    'spec_list' => $spec_list,
                ];
            });
            return $data;
        });
        return [
            'data' => $data[0] ?? [],
            'total' => isset($data[0]) ? count($data[0]) : 0, // 数据总数
        ];
    }
}