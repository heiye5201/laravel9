<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Queries\GoodsQuery;
use App\Http\Resources\Seller\GoodsResource;
use App\Models\Goods;
use App\Models\GoodsSku;
use App\Services\GoodsService;
use App\Services\StoreService;
use Illuminate\Http\Request;

class GoodsController extends Controller
{

    public function index(Request $request, GoodsQuery $query)
    {
        $storeId = app(StoreService::class)->getStoreId()['data'];
        $data = $query->with(['goods_class', 'goods_brand'])->orderBy('id', 'desc')
            ->where('store_id', $storeId)
            ->paginate(intval($request->input('page_size', 25)));

        $resourceData = GoodsResource::collection($data->items());
        // 构建响应数据，将模型实例资源放入 'data' 键中，分页数据放入其他键中
        $responseData = [
            'data' => $resourceData,
            'current_page' => $data->currentPage(),
            'last_page' => $data->lastPage(),
            'per_page' => $data->perPage(),
            'total' => $data->total(),
        ];
        return $this->success($responseData);
    }


    public function store(Request $request)
    {
        $rs = app(GoodsService::class)->addGoods();
        return $this->handle($rs);
    }

    public function update(Request $request, $id)
    {
        $rs = app(GoodsService::class)->editGoods($id);
        return $this->handle($rs);
    }

    public function show($id)
    {
        $rs = app(GoodsService::class)->getGoodsInfo($id);
        return $this->handle($rs);
    }

    public function destroy($id)
    {
        $storeId = app(StoreService::class)->getStoreId()['data'];
        $idArray = array_filter(explode(',', $id), function ($item) {
            return (is_numeric($item));
        });
        $goodsList = Goods::query()->select('id')->where('store_id', $storeId)
            ->whereIn('id', $idArray)->get();
        if (empty($goodsList)) {
            return $this->success();
        }
        $goodsId = [];
        foreach ($goodsList as $v) {
            $goodsId[] = $v->id;
        }
        GoodsSku::query()->where('goods_id', $goodsId)->delete();
        Goods::query()->whereIn('id', $goodsId)->delete();
        return $this->success();
    }
}
