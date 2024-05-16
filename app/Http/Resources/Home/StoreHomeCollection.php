<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/16 23:11
 * description:
 */

namespace App\Http\Resources\Home;

use Illuminate\Http\Resources\Json\ResourceCollection;

class StoreHomeCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function ($item) {
                return [
                    'id' => $item->id,
                    'store_logo' => $item->store_logo,
                    'comment_rate' => $item->comments_count == 0 ? 100 : round((($item->good_comment ?? 0) / $item->comments_count) * 100, 2),
                    'store_name' => $item->store_name,
                    'area_info' => $item->area_info,
                    'store_address' => $item->store_address,
                    'store_company_name' => $item->store_company_name,
                    'distance' => $item->distance > 1000 ? round($item->distance / 1000, 2) . 'km' : round($item->distance, 2) . 'm',
                    'created_at' => $item->created_at->format('Y-m-d H:i:s'),
                ];
            }),
            'total' => $this->total(), // 数据总数
            'last_page' => $this->lastPage(), // 最后页面
            'per_page' => $this->perPage(), // 每页数量
            'current_page' => $this->currentPage(), // 当前页码
        ];
    }
}