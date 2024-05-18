<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Queries\OrderSettlementQuery;
use App\Models\OrderSettlement;
use App\Services\StoreService;
use Illuminate\Http\Request;

class OrderSettlementsController extends Controller
{

    protected $auth = 'users';

    public function index(Request $request, OrderSettlementQuery $query)
    {
        $query = $query->where('store_id', app(StoreService::class)->getStoreId()['data'])
            ->orderBy('id', 'desc');
        $data = $query->paginate(intval($request->input('page_size', 25)));
        return $this->success($data);
    }

    public function show($id)
    {
        $rs = OrderSettlement::query()->where('id', $id)->where('store_id', app(StoreService::class)->getStoreId()['data'])->first();
        return $this->success($rs);
    }
}
