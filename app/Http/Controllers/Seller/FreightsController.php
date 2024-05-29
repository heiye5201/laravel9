<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Queries\FreightsQuery;
use App\Models\Freight;
use App\Services\FreightService;
use App\Services\StoreService;
use Illuminate\Http\Request;

class FreightsController extends Controller
{

    public function index(Request $request, FreightsQuery $query)
    {
        $storeId = app(StoreService::class)->getStoreId()['data'];
        $isAll = $request->input('isAll', false);
        $query = $query->orderBy('is_type', 'desc')
            ->where('store_id', $storeId);
        if ($isAll) {
            $data = $query->get();
        } else {
            $data = $query->paginate(intval($request->input('page_size', 25)));
        }
        return $this->success($data);
    }

    public function update(Request $request, $id)
    {
        return $this->handle(app(FreightService::class)->edit($request->all()));
    }

    public function destroy($id)
    {
        $model = new Freight();
        $storeId = app(StoreService::class)->getStoreId()['data'];
        $idArray = array_filter(explode(',', $id), function ($item) {
            return is_numeric($item);
        });
        $rs = $model->where('store_id', $storeId)->whereIn('id', $idArray)->delete();
        return $this->success($rs);
    }

    public function show($id)
    {
        $data = Freight::query()->find($id)->toArray();
        return $this->success($data);
    }
}
