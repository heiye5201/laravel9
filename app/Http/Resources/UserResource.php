<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/19 22:36
 * description:
 */
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id'                =>  $this->id,
            'nickname'          =>  $this->nickname,
            'username'          =>  $this->username,
            'avatar'            =>  $this->avatar,
            'sex'               =>  $this->sex,
            'phone'             =>  $this->phone,
            'money'             =>  $this->money,
            'frozen_money'      =>  $this->frozen_money,
            'integral'          =>  $this->integral,
            'inviter_id'        =>  $this->inviter_id,
            'user_check'        =>  $this->user_check,
            'wechat_check'      =>  $this->wechat_check,
        ];
    }
}