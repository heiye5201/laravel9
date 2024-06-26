<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/19 00:32
 * description:
 */
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{

    public function toArray($request)
    {
        return [
            'data'=>$this->collection->map(function ($item) {
                return [
                    'id'                    =>  $item->id,
                    'username'              =>  $item->username,
                    'nickname'              =>  $item->nickname,
                    'role_name'             =>  $item->roles->map(function ($roleItem) {
                        return $roleItem->name;
                    }),
                    'phone'                 =>  $item->phone,
                    'money'                 =>  $item->money,
                    'frozen_money'          =>  $item->frozen_money,
                    'integral'              =>  $item->integral,
                    'avatar'                =>  $item->avatar,
                    'ip'                    =>  $item->ip,
                    'login_time'            =>  $item->login_time,
                    'last_login_time'       =>  $item->last_login_time,
                    'created_at'            =>  $item->created_at->format('Y-m-d H:i:s'),
                    'updated_at'            =>  $item->updated_at->format('Y-m-d H:i:s'),
                ];
            }),
            'total'=>$this->total(), // 数据总数
            'per_page'=>$this->perPage(), // 每页数量
            'last_page'=>$this->lastPage(), // 最后页面
            'current_page'=>$this->currentPage(), // 当前页码
        ];
    }
}
