<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Queries\DistributionQuery;
use App\Http\Resources\Seller\DistributionsResource;
use App\Models\Distribution;
use App\Services\StoreService;
use Illuminate\Http\Request;

class DistributionsController extends Controller
{

    public function index(Request $request, DistributionQuery $query)
    {
        $storeId = app(StoreService::class)->getStoreId()['data'];
        $query = $query->where('store_id', $storeId)->orderBy('id', 'desc');
        $data = $query->paginate(intval($request->input('page_size', 25)));
        $resourceData = DistributionsResource::collection($data->items());
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
        $storeId = app(StoreService::class)->getStoreId()['data'];
        $data = Distribution::query()->create([
            'store_id' => $storeId,
            'goods_id' => $request->input('goods_id'),
            'lev_1' => $request->input('lev_1'),
            'lev_2' => $request->input('lev_2'),
            'lev_3' => $request->input('lev_3'),
        ]);
        return $this->success($data);
    }

    public function update(Request $request, $id)
    {
        $storeId = app(StoreService::class)->getStoreId()['data'];
        $rs = Distribution::query()->where('id', intval($id))->update([
            'store_id' => $storeId,
            'goods_id' => $request->input('goods_id'),
            'lev_1' => $request->input('lev_1'),
            'lev_2' => $request->input('lev_2'),
            'lev_3' => $request->input('lev_3'),
        ]);
        return $this->success($rs);
    }

    public function destroy($id)
    {
        $storeId = app(StoreService::class)->getStoreId()['data'];
        $idArray = array_filter(explode(',', $id), function ($item) {
            return is_numeric($item);
        });
        $res = Distribution::query()->whereIn('id', $idArray)->where('store_id', $storeId)->delete();
        return $this->success($res);
    }

    public function show($id)
    {
        $data = Distribution::query()->find($id)->toArray();
        return $this->success($data);
    }
}
