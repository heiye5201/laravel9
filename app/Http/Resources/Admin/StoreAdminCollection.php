<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/18 12:14
 * description:
 */

namespace App\Http\Resources\Admin;

use App\Models\Store;
use Illuminate\Http\Resources\Json\ResourceCollection;

class StoreAdminCollection extends ResourceCollection
{

    public function toArray($request)
    {
        $store = new Store();
        $pass = $store->where('store_verify', 4)->count();
        $wait = $store->where('store_verify', 2)->count();
        $error = $store->where('store_verify', 3)->count();
        $create = $store->where('store_verify', 1)->count();
        return [
            'data'=>$this->collection->map(function ($item) use ($pass, $wait, $error, $create) {
                return [
                    'id'                    =>  $item->id,
                    'store_name'            =>  $item->store_name,
                    'area_info'             =>  $item->area_info,
                    'store_status'          =>  $item->store_status,
                    'store_verify'          =>  $item->store_verify,
                    'created_at'            =>  $item->created_at->format('Y-m-d H:i:s'),
                    'updated_at'            =>  $item->updated_at->format('Y-m-d H:i:s'),
                ];
            }),
            'total'=>$this->total(), // 数据总数
            'last_page'=>$this->lastPage(), // 最后页面
            'per_page'=>$this->perPage(), // 每页数量
            'current_page'=>$this->currentPage(), // 当前页码
            // 统计
            'count'=>[
                'pass'=>$pass,
                'wait'=>$wait,
                'error'=>$error,
                'create'=>$create,
            ]
        ];
    }
}
