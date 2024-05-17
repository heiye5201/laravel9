<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\KuaiBaoService;
use App\Services\OrderService;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    // 下单前的数据处理
    public function before()
    {
        return $this->handle(app(OrderService::class)->createOrderBefore());
    }

    // 创建订单
    public function create()
    {
        return $this->handle(app(OrderService::class)->createOrder());
    }

    // 下单后数据处理
    public function after()
    {
        return $this->handle(app(OrderService::class)->createOrderAfter());
    }

    // 支付订单
    public function pay()
    {
        return $this->handle(app(OrderService::class)->payOrder());
    }

    // 验证支付状态
    public function check()
    {
        $check = app(PaymentService::class)->check(request('order_id'));
        if ($check['status']) {
            return $this->success($check['data']);
        }
        return $this->success(['code'=>'fail','msg'=>$check['msg']]);
    }

    // 订单列表
    public function orders()
    {
        return $this->handle(app(OrderService::class)->getOrders());
    }

    // 获取订单详情
    public function show($id)
    {
        return $this->handle(app(OrderService::class)->getOrderInfoById($id));
    }

    // 修改状态
    public function edit($id)
    {
        return $this->handle(app(OrderService::class)->editOrderStatus($id, request()->order_status??1));
    }

    // 物流查询
    public function express(Request $request)
    {
        // 根据订单Id查询
        $order = Order::query()->where(['user_id'=>$this->getUserId('users'),'id'=>$request->id])->first();
        if(!$order) return $this->error(__('tip.order.empty'));
        return $this->handle(app(KuaiBaoService::class)->getExpressInfo($order->delivery_no, $order->delivery_code, $order->receive_tel));
    }
}
