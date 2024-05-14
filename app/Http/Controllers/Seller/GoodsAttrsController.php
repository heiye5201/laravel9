<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Queries\GoodsAttrQuery;
use App\Http\Resources\Seller\GoodsAttrsResource;
use App\Models\GoodsAttr;
use App\Models\GoodsSpecs;
use App\Services\StoreService;
use Illuminate\Http\Request;

class GoodsAttrsController extends Controller
{
    public function index(Request $request, GoodsAttrQuery $query)
    {
        $storeId = app(StoreService::class)->getStoreId()['data'];
        $query = $query->with(['specs'])->orderBy('id', 'desc')->where('store_id', $storeId);
        $isAll = $request->input('isAll', false);
        if ($isAll) {
            $responseData = $query->get();
        } else {
            $data = $query->paginate(intval($request->input('page_size', 25)));
            $resourceData = GoodsAttrsResource::collection($data->items());
            // 构建响应数据，将模型实例资源放入 'data' 键中，分页数据放入其他键中
            $responseData = [
                'data' => $resourceData,
                'current_page' => $data->currentPage(),
                'last_page' => $data->lastPage(),
                'per_page' => $data->perPage(),
                'total' => $data->total(),
            ];
        }
        return $this->success($responseData);
    }

    public function store(Request $request)
    {
        $storeId = app(StoreService::class)->getStoreId()['data'];
        $attrId = GoodsAttr::query()->insertGetId([
            'store_id' => $storeId ?? 0,
            'name' => $request->name ?? '',
            'created_at' => now(),
        ]);
        $specs = $request->specs ?? [];
        if (!empty($specs)) {
            $specsData = [];
            foreach ($specs as $v) {
                $specsData[] = [
                    'attr_id' => $attrId,
                    'name' => $v,
                ];
            }
            GoodsSpecs::query()->insert($specsData);
        }
        return $this->success($attrId);
    }

    public function update(Request $request, $id)
    {
        $storeId = app(StoreService::class)->getStoreId()['data'];
        GoodsAttr::query()->where('store_id', $storeId)->where('id', $id)->update(['name' => $request->name ?? '']);
        GoodsSpecs::query()->where('attr_id', $id)->delete(); // 删除所有规格
        $specs = $request->specs ?? [];
        if (!empty($specs)) {
            $specsData = [];
            foreach ($specs as $v) {
                $specsData[] = [
                    'attr_id' => $id,
                    'name' => $v,
                ];
            }
            GoodsSpecs::query()->insert($specsData);
        }
        return $this->success($id);
    }

    public function destroy($id)
    {
        $storeId = app(StoreService::class)->getStoreId()['data'];
        try {
            $ids = explode(",", $id);
            $rs = GoodsAttr::query()->where('store_id', $storeId)->whereIn('id', $ids)->delete();
            GoodsSpecs::query()->whereIn('attr_id', explode('id', $id))->delete();
            return $this->handle($rs);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function show($id)
    {
        $data = GoodsAttr::query()->with(['specs'])->find($id)->toArray();
        $data['specs'] = collect($data['specs'] ?? [])->pluck('name');
        return $this->success($data);
    }
}
