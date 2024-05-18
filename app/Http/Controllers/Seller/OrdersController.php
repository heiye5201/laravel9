<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Queries\OrderSellerQuery;
use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderSeller;
use App\Services\KuaiBaoService;
use App\Services\OrderService;
use App\Services\StoreService;
use Illuminate\Http\Request;

class OrdersController extends Controller
{

    protected $auth = 'users';

    public function index(Request $request, OrderSellerQuery $query)
    {
        $query = $query->where('store_id', app(StoreService::class)->getStoreId()['data'])
            ->orderBy('id', 'desc');

        if ($request['order_status']) {
            $query = $query->where('apply_status', $request['order_status']);
        }
        if ($request->input('refund_status')) {
            $query = $query->where('refund_status', $request->input('refund_status'));
        }
        $data = $query->paginate(intval($request->input('page_size', 25)));
        return $this->success(new OrderCollection($data));
    }

    public function show($id)
    {
        $data = Order::query()->with(['order_goods'])->find($id);
        return $this->success(new OrderResource($data));
    }

    // 修改订单信息
    public function update(Request $request, $id)
    {
        $res = OrderSeller::query()->where('id', $id)
            ->update([
                'delivery_no' => $request->input('delivery_no'),
                'receive_name' => $request->input('receive_name'),
                'receive_tel' => $request->input('receive_tel'),
                'receive_area' => $request->input('receive_area'),
                'receive_address' => $request->input('receive_address')
            ]);
        return $this->success($res);
    }

    // 获取订单商品格式化列表
    public function all()
    {
        return $this->handle(app(OrderService::class)->createOrderAfter());
    }

    // 编辑发货信息
    public function edit(Request $request)
    {
        $id = $request->id ?? 0;
        $status = $request->status ?? 3;
        return $this->handle(app(OrderService::class)->editOrderStatus($id, $status, 'seller'));
    }


    // 物流查询
    public function express(Request $request)
    {
        // 根据订单Id查询
        $order = Order::query()->where(['store_id'=>$this->getService('Store')->getStoreId()['data'],'id'=>$request->id])->first();
        if(!$order) return $this->error(__('tip.order.empty'));
        return $this->handle(app(KuaiBaoService::class)->getExpressInfo($order->delivery_no, $order->delivery_code, $order->receive_tel));
    }
}
