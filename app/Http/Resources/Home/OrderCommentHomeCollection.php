<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/16 23:32
 * description:
 */

namespace App\Http\Resources\Home;

use App\Services\ToolService;
use Illuminate\Http\Resources\Json\ResourceCollection;

class OrderCommentHomeCollection extends ResourceCollection
{
    public function toArray($request)
    {
        $tool = new ToolService();
        return [
            'data' => $this->collection->map(function ($item) use ($tool) {
                return [
                    'id' => $item->id,
                    'nickname' => $tool->formatTrueName2($item->user->nickname),
                    'avatar' => $item->user->avatar,
                    'score' => $item->score,
                    'agree' => $item->agree,
                    'service' => $item->service,
                    'speed' => $item->speed,
                    'content' => $item->content,
                    'image' => empty($item->image) ? [] : explode(',', $item->image),
                    'reply' => $item->reply,
                    'reply_time' => $item->reply_time,
                    'created_at' => $item->created_at,//->format('Y-m-d H:i:s'),
                ];
            }),
            'total' => $this->total(), // 数据总数
            'last_page' => $this->lastPage(), // 最后页面
            'per_page' => $this->perPage(), // 每页数量
            'current_page' => $this->currentPage(), // 当前页码
        ];
    }
}