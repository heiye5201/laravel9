<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Resources\Seller\SeckillResource;
use App\Models\Seckill;
use App\Services\StoreService;
use Illuminate\Http\Request;

class SeckillsController extends Controller
{

    public function index(Request $request)
    {
        $storeId = app(StoreService::class)->getStoreId()['data'];
        $query = Seckill::query()->where('store_id', $storeId)->orderBy('id', 'desc');
        $data = $query->paginate(intval($request->input('page_size', 25)));

        $resourceData = SeckillResource::collection($data->items());
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
        if ($request->discount > 100) {
            return $this->error(__('tip.discount.over100'));
        }
        $data = Seckill::query()->create([
            'store_id' => $storeId,
            'goods_id' => $request->input('goods_id'),
            'discount' => $request->input('discount'),
            'start_time' => $request->input('start_time'),
            'end_time' => $request->input('end_time', now()),
        ]);
        return $this->success($data);
    }

    public function update(Request $request, $id)
    {
        $storeId = app(StoreService::class)->getStoreId()['data'];
        if ($request->discount > 100) {
            return $this->error(__('tip.discount.over100'));
        }
        $data = Seckill::query()->where('id', $id)
            ->where('store_id', $storeId)->update([
                'goods_id' => $request->input('goods_id'),
                'discount' => $request->input('discount'),
                'start_time' => $request->input('start_time'),
                'end_time' => $request->input('end_time', now()),
            ]);
        return $this->success($data);
    }


    public function destroy($id)
    {
        $storeId = app(StoreService::class)->getStoreId()['data'];
        $idArray = array_filter(explode(',', $id), function ($item) {
            return is_numeric($item);
        });
        $res = Seckill::query()->whereIn('id', $idArray)->where('store_id', $storeId)->delete();
        return $this->success($res);
    }


    public function show($id)
    {
        $data = Seckill::query()->find($id)->toArray();
        return $this->success($data);
    }
}
