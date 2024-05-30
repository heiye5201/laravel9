<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\GoodsClass;
use App\Models\StoreClass;
use App\Services\StoreService;
use App\Services\ToolService;
use Illuminate\Http\Request;

class StoresController extends Controller
{

    // 获取店铺分类
    public function store_classes()
    {
        $storeId = app(StoreService::class)->getStoreId()['data'];
        $rs = StoreClass::query()->where('store_id', $storeId)->first();
        if ($rs && !empty($rs->class_id)) {
            $class_id = [];
            $classId = json_decode($rs->class_id, true);
            foreach ($classId as $v) {
                foreach ($v as $vo) {
                    $class_id[] = intval($vo);
                }
            }
            $class = GoodsClass::query()->whereIn('id', $class_id)->get();
            $data = app(ToolService::class)->getChildren($class);
            return $this->success($data);
        } else {
            return $this->error('class not found');
        }
    }

    // 获取店铺配置
    public function show($id)
    {
        $storeId = app(StoreService::class)->getStoreId()['data'];
        $rs = app(StoreService::class)->getStoreInfo($storeId);
        return $this->handle($rs);
    }

    // 修改
    public function update(Request $request, $id)
    {
        $storeId = app(StoreService::class)->getStoreId()['data'];
        $rs = app(StoreService::class)->editStore($request->all(), $storeId);
        return $this->handle($rs);
    }
}
