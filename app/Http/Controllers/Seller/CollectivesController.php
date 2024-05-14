<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Resources\Seller\CollectiveResource;
use App\Models\Collective;
use App\Services\StoreService;
use Illuminate\Http\Request;

class CollectivesController extends Controller
{
    protected $modelName = 'Collective';

    public function index(Request $request)
    {
        $storeId = app(StoreService::class)->getStoreId()['data'];
        $query = Collective::query()->where('store_id', $storeId)->orderBy('id', 'desc');
        $data = $query->paginate(intval($request->input('page_size', 25)));
        $resourceData = CollectiveResource::collection($data->items());
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
        $request->offsetSet('store_id', $storeId);
        if ($request->discount > 100) {
            return $this->error(__('tip.discount.over100'));
        }
        if ($request->need < 2) {
            return $this->error(__('tip.discount.need'));
        }
        $data = Collective::query()->create([
            'store_id' => $storeId,
            'goods_id' => $request->input('goods_id'),
            'discount' => $request->input('discount'),
            'need' => $request->input('need'),
        ]);
        return $this->success($data);
    }

    public function update(Request $request, $id)
    {
        $storeId = app(StoreService::class)->getStoreId()['data'];
        if ($request->discount > 100) {
            return $this->error(__('tip.discount.over100'));
        }
        if ($request->need < 2) {
            return $this->error(__('tip.discount.need'));
        }
        $data = Collective::query()->where('id', $id)
            ->where('store_id', $storeId)->update([
                'goods_id' => $request->input('goods_id'),
                'discount' => $request->input('discount'),
                'need' => $request->input('need'),
            ]);
        return $this->success($data);
    }

    public function destroy($id)
    {
        $storeId = app(StoreService::class)->getStoreId()['data'];
        $idArray = array_filter(explode(',', $id), function ($item) {
            return is_numeric($item);
        });
        $res = Collective::query()->whereIn('id', $idArray)->where('store_id', $storeId)->delete();
        return $this->success($res);
    }


    public function show($id)
    {
        $data = Collective::query()->find($id)->toArray();
        return $this->success($data);
    }
}
