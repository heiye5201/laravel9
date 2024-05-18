<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderSettlement;
use App\Services\OrderSettlementService;
use Illuminate\Http\Request;

class OrderSettlementsController extends Controller
{

    public function index(Request $request)
    {
        $query = OrderSettlement::query()->orderBy('id', 'desc');
        $data = $query->paginate(intval($request->input('page_size', 25)));
        return $this->success($data);
    }


    public function show($id)
    {
        $data = OrderSettlement::query()->find($id);
        return $this->success($data);
    }


    // 手动结算订单
    public function handle_sett()
    {
        return $this->handle(app(OrderSettlementService::class)->add(false));
    }
}
