<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/18 23:07
 * description:
 */
namespace App\Http\Resources;

use App\Services\ToolService;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderCommentResource extends JsonResource
{

    public function toArray($request)
    {
        $tool = new ToolService;
        return [
            'id'                            =>  $this->id,
            'nickname'                      =>  $this->user->nickname,
            'avatar'                        =>  $this->user->avatar,
            'goods_master_image'            =>  $tool->thumb($this->goods->goods_master_image),
            'goods_name'                    =>  $this->goods->goods_name,
            'score'                         =>  $this->score,
            'agree'                         =>  $this->agree,
            'service'                       =>  $this->service,
            'speed'                         =>  $this->speed,
            'content'                       =>  $this->content,
            'image'                         =>  empty($this->image)?[]:explode(',', $this->image),
            'reply'                         =>  $this->reply,
            'reply_time'                    =>  $this->reply_time,
            'created_at'                    =>  $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}