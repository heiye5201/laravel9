<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Services\GoodsService;
use App\Services\StoreService;
use Illuminate\Http\Request;

class StoresController extends Controller
{
    public function join()
    {
        return $this->handle(app(StoreService::class)->createStore());
    }

    public function edit(Request $request)
    {
        return $this->handle(app(StoreService::class)->editStore($request->all(),true));
    }

    // 获取详情
    public function info()
    {
        try {
            $data = app(StoreService::class)->getStoreInfo(true);
            return $this->handle($data);
        } catch (\Exception $e) {
            return $this->success([], $e->getMessage());
        }
    }

    // 获取列表
    public function stores(Request $request)
    {
        return $this->handle(app(StoreService::class)->stores($request->all()));
    }

    // 无权限获取商品信息
    public function show($id)
    {
        $data = app(StoreService::class)->getStoreInfoAndRate($id);
        $data['data']['sale_list'] = app(GoodsService::class)->sortGoods($id)['data'];
        return $this->handle($data);
    }
}
