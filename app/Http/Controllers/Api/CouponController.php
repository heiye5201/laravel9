<?php
/**
 * autor      : jiweijian
 * createTime : 2024/7/26 21:55
 * description:
 */
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function getList(Request $request)
    {
        $data = [
            'list' => [
                [
                    'apply_range' => 10,
                    'apply_range_config' => [],
                    'coupon_id' => 100,
                    'coupon_type' => 10,
                    'describe' => '',
                    'discount' => 1,
                    'end_time' => '',
                    'expire_day' => 7,
                    'expire_type'=> 10,
                    'min_price' => 100,
                    'name' => '满100减10',
                    'reduce_price'=> '10.00',
                    'sort'=> 100,
                    'start_time'=>'',
                    'state'=> [
                        'text' => '正常',
                        'value' => 1
                    ],
                ],
                [
                    'apply_range' => 10,
                    'apply_range_config' => [],
                    'coupon_id' => 101,
                    'coupon_type' => 10,
                    'describe' => '',
                    'discount' => 1,
                    'end_time' => '',
                    'expire_day' => 7,
                    'expire_type'=> 10,
                    'min_price' => 300,
                    'name' => '满300减30',
                    'reduce_price'=> 30.00,
                    'sort'=> 100,
                    'start_time'=>'',
                    'state'=> [
                        'text' => '正常',
                        'value' => 1
                    ],
                ]
            ]
        ];
        return $this->app_success($data);
    }
}