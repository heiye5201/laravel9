<?php
/**
 * autor      : jiweijian
 * createTime : 2024/7/26 22:13
 * description:
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\GoodsService;
use Illuminate\Http\Request;

class GoodsController extends Controller
{
    public function getList(Request $request)
    {
        $params['class_id'] = $request->get('categoryId', 0);
        $params['per_page'] = 10;
        $data = [
            'list' => app(GoodsService::class)->getGoodsPage($params)['data'] ?? [],
        ];
        return $this->app_success($data);
    }


    public function getDetail(Request $request)
    {
        $goodsId = $request->get('goodsId');
        $verifyStatus = $request->get('verifyStatus');
        $data = [
            'detail' => app(GoodsService::class)->getGoodsInfo($goodsId)['data'] ?? [],
        ];
        return $this->app_success($data);
    }
}