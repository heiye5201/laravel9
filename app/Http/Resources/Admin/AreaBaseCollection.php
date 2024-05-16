<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/13 14:07
 * description:
 */

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AreaBaseCollection extends ResourceCollection
{

    public function toArray($request)
    {
        return $this->collection->map(function ($item) {
            return [
                'id' => $item->id,
                'code' => $item->code,
                'pid' => $item->pid,
                'deep' => $item->deep,
                'name' => $item->name,
                'leaf' => (isset($item->hasChildren) && !empty($item->hasChildren)) ? false : true,
            ];
        });
    }
}
