<?php
/**
 * autor      : jiweijian
 * createTime : 2024/7/26 22:36
 * description:
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function getList(Request $request)
    {
        $params['class_id'] = $request->get('categoryId', 0);
        $params['per_page'] = 10;
        $data = [
            'cartTotal' => 1,
            'list' => [
                [
                    'id'=> 1,
                    'user_id' => 13,
                    'goods_sku_id' => 143,
                    'goods_num' => 3,
                    'goods_id' => 123,
                    'goods' => [
                        'goods_image' => 'https://static.yoshop.xany6.com/10001/20210316/41cdb778199f99ebebb6090680f382fc.png',
                        'goods_name' => '简约风条纹客厅沙发卧室床头抱枕靠垫套',
                        'goods_no' => 'sdfdsf',
                        'goods_price_max' => 133,
                        'goods_price_min' => 123,
                        'goods_sales' => 12,
                        'status' => 10,
                        'stock_total' => 133,
                        'skuInfo' => [
                            'id' => 143,
                            'goods_id' => 123,
                            'goods_price' => 124,
                            'line_price' => 133,
                            'stock_num' => 12,
                        ],
                    ],
                ]
            ]
        ];
        return $this->app_success($data);
    }


    public function getTotal(Request $request)
    {
        $data['cartTotal'] = 1;
        return $this->app_success($data);
    }
}