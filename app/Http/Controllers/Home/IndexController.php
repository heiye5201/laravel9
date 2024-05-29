<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\GoodsBrand;
use App\Models\GoodsClass;
use App\Models\Order;
use App\Services\AdvService;
use App\Services\CartService;
use App\Services\ConfigsService;
use App\Services\FavoriteService;
use App\Services\GoodsService;
use App\Services\OrderService;
use App\Services\ToolService;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    // 首页公共数据
    public function common(Request $request)
    {
        $data['classes'] = app(ToolService::class)->getChildren(GoodsClass::query()->orderBy('is_sort', 'asc')->get()); // 商品分类
        $data['brands'] = GoodsBrand::query()->orderBy('is_sort', 'asc')->get(); // 商品品牌
        // 可以使用 Resource 控制达到脱敏
        $data['common'] = app(ConfigsService::class)->getFormatConfig([
            'web_name','logo','index_name','keyword','description','mobile','email','icp','close_status','amap','close_reason'
        ]);
        $data['ip'] = $request->getClientIp();
        // 购物车数据
        $data['cart'] = app(CartService::class)->getCount()['data'];
        return $this->success($data);
    }

    // 首页信息
    public function home(Request $request)
    {
        $data['goods'] = app(GoodsService::class)->master(8)['data'];
        //首页广告
        $data['adv'] = app(AdvService::class)->advNew('home_banner');
        //分类广告
        $data['class_adv'] = app(AdvService::class)->advNew('class_banner');
        //品牌图标
        $brand = GoodsBrand::query()->where('recommend',1)->limit(3)->get();
        $brandData = [];
        foreach ($brand as $val) {
            $info['brand_id'] = $val['id'];
            $brandData[] = [
                'image'=>$val['thumb'],
                'name'=>$val['name'],
                'id'=>$val['id'],
                'url'=>'/s/'.base64_encode(json_encode($info))
            ];
        }
        $data['brand'] = $brandData;
        return $this->success($data);
    }

    // 用户首页信息
    public function default(Request $request)
    {
        $userId = $this->getUserId('users');
        $data = [];
        // 获取订单数量
        $data['count'][] = Order::query()->where(['user_id'=>$userId,'order_status'=>1])->count();
        $data['count'][] = Order::query()->where(['user_id'=>$userId,'order_status'=>2])->count();
        $data['count'][] = Order::query()->where(['user_id'=>$userId,'order_status'=>3])->count();
        $data['count'][] = Order::query()->where(['user_id'=>$userId,'order_status'=>4])->count();
        $data['count'][] = Order::query()->where(['user_id'=>$userId,'order_status'=>5])->count();
        $data['order'] = app(OrderService::class)->getOrders()['data'];
        $data['fav'] = app(FavoriteService::class)->fav($request->all())['data'];
        return $this->success($data);
    }
}
