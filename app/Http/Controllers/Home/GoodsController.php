<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Services\CollectiveService;
use App\Services\CouponService;
use App\Services\GoodsService;
use App\Services\OrderCommentService;
use App\Services\SeckillService;
use App\Services\StoreService;
use Illuminate\Http\Request;

class GoodsController extends Controller
{
    public function goods()
    {
        return $this->handle(app(GoodsService::class)->all());
    }

    public function show($id)
    {
        $goods_info = app(GoodsService::class)->getGoodsInfo($id);
        if ($goods_info['status']) {
            $goods_info['data']['store_info'] = app(StoreService::class)->getStoreInfoAndRate($goods_info['data']['store_id'])['data'];
            $goods_info['data']['rate'] = $goods_info['data']['store_info']['rate'];

            $goods_info['data']['comment_statistics'] = app(OrderCommentService::class)->commentStatistics($goods_info['data']['id'])['data'];

            $goods_info['data']['sale_list'] = app(GoodsService::class)->sortGoods($goods_info['data']['store_id'], 'store_id', 6, ['class_id'=>$goods_info['data']['class_id']])['data']; // 销售排名

            $goods_info['data']['coupons'] = app(CouponService::class)->getCouponByStoreId($goods_info['data']['store_id'])['data']; // 优惠券

            $seckill_info = app(SeckillService::class)->seckillInfoByGoodsId($id);
            $goods_info['data']['seckills'] = $seckill_info['status']?$seckill_info['data']:false; // 秒杀
            $collective_info = app(CollectiveService::class)->getCollectiveInfoByGoodsId($id);
            $goods_info['data']['collectives'] = $collective_info['status']?$collective_info['data']:false; // 团购
            $goods_info['data']['collective_list'] = app(CollectiveService::class)->getCollectiveLogByGoodsId($id)['data']; // 正在团的
        }
        return $this->handle($goods_info);
    }

    public function goods_comments($id)
    {
        $id = intval($id);
        return $this->handle(app(OrderCommentService::class)->commentList($id));
    }
}
