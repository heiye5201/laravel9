<?php

namespace App\Http\Resources\Seller;

use Illuminate\Http\Resources\Json\JsonResource;

class GoodsAttrsResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'store_id' => $this->store_id,
            'specs' => collect($this->specs)->pluck('name')
        ];
    }

    public function withResponse($request, $response)
    {
        // 获取Paginator实例
        $paginator = $this->resource->paginator;
        // 添加分页信息到响应中
        $response->setData(array_merge($response->getData(true), [
            'pagination' => [
                'total' => $paginator->total(),
                'per_page' => $paginator->perPage(),
                'current_page' => $paginator->currentPage(),
                // 可以根据需要添加其他分页信息
            ],
        ]));
    }
}
