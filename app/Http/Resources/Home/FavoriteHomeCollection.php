<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/16 21:57
 * description:
 */

namespace App\Http\Resources\Home;

use App\Services\ToolService;
use Illuminate\Http\Resources\Json\ResourceCollection;

class FavoriteHomeCollection extends ResourceCollection
{
    public function toArray($request)
    {
        $tool = new ToolService();
        return [
            'data' => $this->collection->map(function ($item) use ($tool) {
                return [
                    'id' => $item->id,
                    'out_id' => $item->out_id,
                    'is_type' => $item->is_type,
                    'goods_name' => $item->goods->goods_name ?? '-',
                    'goods_master_image' => empty($item->goods) ? '' : $tool->thumb($item->goods->goods_master_image, 150),
                    'goods_price' => empty($item->goods) ? '0.00' : ($item->goods->goods_skus->isEmpty() ? $item->goods->goods_price : ($item->goods->goods_skus->toArray()[0]['goods_price'] ?? '0.00')),
                    'created_at' => empty($this->created_at) ? now()->format('Y-m-d H:i:s') : $this->created_at->format('Y-m-d H:i:s'),
                ];
            }),
            'total' => $this->total(), // 数据总数
            'last_page' => $this->lastPage(), // 最后页面
            'per_page' => $this->perPage(), // 每页数量
            'current_page' => $this->currentPage(), // 当前页码
        ];
    }
}