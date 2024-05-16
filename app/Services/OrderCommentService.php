<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/16 23:24
 * description:
 */

namespace App\Services;

use App\Http\Resources\Home\OrderCommentHomeCollection;
use App\Models\Order;
use App\Models\OrderComment;
use Illuminate\Support\Facades\DB;

class OrderCommentService extends BaseService
{

    public function commentStatistics($goodsId)
    {
        $all = OrderComment::query()->where('goods_id', $goodsId)->count();
        $good = OrderComment::query()->whereRaw('(score+agree+speed+service)>=15')->where('goods_id', $goodsId)->count();
        $commonly = OrderComment::query()->whereRaw('(score+agree+speed+service)<15')->whereRaw('(score+agree+speed+service)>10')->where('goods_id', $goodsId)->count();
        $bad = OrderComment::query()->whereRaw('(score+agree+speed+service)<=10')->where('goods_id', $goodsId)->count();
        $data = [
            'all' => $all,
            'good' => $good ?? 0,
            'commonly' => $commonly ?? 0,
            'bad' => $bad ?? 0,
            'rate' => $all == 0 ? 100 : round((($good ?? 0) / $all) * 100, 2),
        ];
        foreach ($data as &$v) {
            $v = $v > 999 ? '999+' : $v;
        }
        return $this->format($data);
    }

    // 获取评论列表
    public function commentList($id, $whereName = "goods_id")
    {
        $model = OrderComment::query()->select(DB::raw("*,(score+agree+speed+service) as sum_rate"))->with('user')->where($whereName, $id)->orderBy('created_at', 'desc');
        if (request('is_type') == 1) {
            $model = $model->having('sum_rate', '>=', 15);
        }
        if (request('is_type') == 2) {
            $model = $model->having('sum_rate', '<', 15)->having('sum_rate', '>', 10);
        }
        if (request('is_type') == 3) {
            $model = $model->having('sum_rate', '<=', 10);
        }
        $list = $model->paginate(request()->per_page ?? 30);
        return $this->format(new OrderCommentHomeCollection($list));
    }

    // 定时任务系统添加评论
    public function systemAdd($ids = [])
    {
        $order_list = Order::query()->with('order_goods')->whereIn('id', $ids)->get();
        if ($order_list->isEmpty()) {
            return $this->formatError('order_list is empty obj systemAdd.');
        }
        $data = [];
        $score = 5.00;
        $agree = 5.00;
        $speed = 5.00;
        $content = '非常好！';
        $image = [];
        foreach ($order_list as $v) {
            foreach ($v['order_goods'] as $vo) {
                $comment = [];
                $comment['user_id'] = $v['user_id'];
                $comment['goods_id'] = $vo['goods_id'];
                $comment['order_id'] = $v['id'];
                $comment['store_id'] = $v['store_id'];
                $comment['score'] = $score;
                $comment['agree'] = $agree;
                $comment['service'] = $speed;
                $comment['content'] = $content;
                $comment['image'] = empty($image) ? '' : implode(',', $image);
                $comment['created_at'] = now();
                $data[] = $comment;
            }
        }
        $rs = OrderComment::query()->insert($data);
        Order::query()->whereIn('id', $ids)->update(['order_status' => 6, 'comment_time' => now()]);
        return $this->format($rs);
    }
}