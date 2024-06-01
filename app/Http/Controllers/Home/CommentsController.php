<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Http\Queries\OrderCommentQuery;
use App\Http\Resources\OrderCommentCollection;
use App\Models\Order;
use App\Models\OrderComment;
use App\Models\OrderGoods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentsController extends Controller
{

    public function index(Request $request, OrderCommentQuery $query)
    {
        $data = $query->orderBy('id', 'desc')
            ->where('user_id', $this->getUserId('users'))
            ->paginate(intval($request->input('page_size', 25)));
        return $this->success(new OrderCommentCollection($data));
    }

    public function store(Request $request)
    {
        $userId = $this->getUserId('users');
        $orderId = $request->input('order_id', 0);
        if (empty($orderId)) {
            return $this->error('not found order');
        }
        $order = Order::query()->find($orderId);
        if ($order->user_id != $userId) {
            return $this->error('not allow');
        }
        if ($order->order_status != 4) {
            return $this->success();
        }
        $orderGoods = OrderGoods::query()->where('order_id', $orderId)->get();
        try {
            DB::beginTransaction();
            $dataToInsert = [];
            foreach ($orderGoods as $goods) {
                $image = $request->input('image', '');
                $image = empty($image) ? '' : implode(',', $image);
                $dataToInsert[] = [
                    'user_id'   => $userId,
                    'order_id'  => $order->id,
                    'goods_id'  => $goods['goods_id'],
                    'store_id'  => $order->store_id,
                    'score'     => $request->input('score', 5),
                    'agree'     => $request->input('agree', 5),
                    'service'   => $request->input('service', 5),
                    'speed'     => $request->input('speed', 5),
                    'content'   => $request->input('content', ''),
                    'image'     => $image,
                ];
            }
            OrderComment::query()->insert($dataToInsert);
            $order->order_status = 6;
            $order->comment_time = now();
            $order->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return $this->error($e->getMessage());
        }
        return $this->success();
    }
}
