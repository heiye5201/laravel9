<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\IntegralGoods;
use App\Models\IntegralGoodsClass;
use App\Services\IntegralGoodsService;
use Illuminate\Http\Request;

class IntegralController extends Controller
{
    protected $modelName = 'IntegralGoods';

    public function home()
    {
        $data['recommend'] = IntegralGoods::query()->where('goods_status', 1)->where('is_recommend', 1)->take(4)->orderBy('goods_sale', 'desc')->get();
        $data['list'] = IntegralGoodsClass::query()->with(['integral_goods'=>function ($q) {
            $q->where('goods_status', 1)->take(4)->orderBy('goods_sale', 'desc');
        }])->get();
        $data['banner'] =  [];
        return $this->success($data);
    }

    public function integral_class()
    {
        return $this->success(IntegralGoodsClass::query()->get());
    }

    public function index(Request $request)
    {
        return $this->handle(app(IntegralGoodsService::class)->search());
    }

    public function pay()
    {
        return $this->handle(app(IntegralGoodsService::class)->createOrder());
    }

    // 获取订单列表
    public function integral_orders()
    {
        return $this->handle($this->getService('base')->getPageData('IntegralOrder'));
    }
}
