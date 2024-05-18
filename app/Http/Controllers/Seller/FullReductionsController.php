<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\FullReduction;
use App\Services\StoreService;
use Illuminate\Http\Request;

class FullReductionsController extends Controller
{

    public function index(Request $request)
    {
        $storeId = app(StoreService::class)->getStoreId()['data'];
        $query = FullReduction::query()->where('store_id', $storeId)->orderBy('id', 'desc');
        $data = $query->paginate(intval($request->input('page_size', 25)));
        return $this->success($data);
    }

    public function store(Request $request)
    {
        $storeId = app(StoreService::class)->getStoreId()['data'];
        $request->offsetSet('store_id', $storeId);

        $data = FullReduction::query()->create([
            'store_id' => $storeId,
            'name' => $request->input('name'),
            'money' => $request->input('money'),
            'use_money' => $request->input('use_money'),
            'start_time' => $request->input('start_time'),
            'end_time' => $request->input('end_time', now()),
        ]);
        return $this->success($data);
    }

    public function update(Request $request, $id)
    {
        $storeId = app(StoreService::class)->getStoreId()['data'];
        $data = FullReduction::query()->where('id', $id)
            ->where('store_id', $storeId)->update([
                'name' => $request->input('name'),
                'money' => $request->input('money'),
                'use_money' => $request->input('use_money'),
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
        $res = FullReduction::query()->whereIn('id', $idArray)->where('store_id', $storeId)->delete();
        return $this->success($res);
    }


    public function show($id)
    {
        $data = FullReduction::query()->find($id)->toArray();
        return $this->success($data);
    }
}
