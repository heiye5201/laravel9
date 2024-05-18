<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/18 11:48
 * description:
 */
namespace App\Http\Resources\Home;

use App\Services\ToolService;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CollectiveLogHomeCollection extends ResourceCollection
{
    public function toArray($request)
    {
        $tool_service = new ToolService();
        return $this->collection->map(function ($item) use ($tool_service) {
            return [
                'id'                        =>  $item->id,
                'need'                      =>  $item->need,
                'nickname'                  =>  $tool_service->formatTrueName2($item->user->nickname),
                'avatar'                    =>  $item->user->avatar,
                'orders_count'              =>  $item->orders_count,
            ];
        });
    }
}