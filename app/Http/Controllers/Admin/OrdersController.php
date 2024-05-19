<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Queries\OrderQuery;
use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Services\KuaiBaoService;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrdersController extends Controller
{

    public function index(Request $request, OrderQuery $query)
    {
        $query = $query->orderBy('id', 'desc');
        $data = $query->paginate(intval($request->input('page_size', 25)));
        return $this->success(new OrderCollection($data));
    }

    public function show($id)
    {
        $data = Order::query()->with(['order_goods'])->find($id);
        return $this->success(new OrderResource($data));
    }


    // 获取订单商品格式化列表
    public function all()
    {
        return $this->handle(app(OrderService::class)->createOrderAfter());
    }

    // 物流查询
    public function express(Request $request)
    {
        // 根据订单Id查询
        $order = Order::query()->where(['id'=>$request->id])->first();
        if(!$order) return $this->error(__('tip.order.empty'));
        return $this->handle(app(KuaiBaoService::class)->getExpressInfo($order->delivery_no, $order->delivery_code, $order->receive_tel));
    }

    public function applyStatus(Request $request){
        return $this->handle(app(OrderService::class)->applyStatus());
    }
}
