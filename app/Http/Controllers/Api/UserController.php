<?php
/**
 * autor      : jiweijian
 * createTime : 2024/7/26 23:52
 * description:
 */
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function getInfo(Request $request)
    {
        $rs = [
            'userInfo' => [
                'user_id' => 123,
                'mobile' => '18309876545',
                'nick_name' => '18309876545',
                'gender' => '男',
                'country' => '',
                'province' => '',
                'city' => '',
                'address_id' => 1,
                'balance' => 0,
                'points' => 0,
                'pay_money' => 0.0,
                'expend_money' => 0.0,
                'grade_id' => 1,
                'platform' => 'H5',
                'last_login_time' => 1722008790,
                'avatar' => null,
                'grade' => null,
            ],
        ];
        return $this->app_success($rs);
    }


    public function getAssets()
    {
        $rs = [
            'assets'=> [
                'balance' => 0,
                'coupon' => 0,
                'points' => 2
            ]
        ];
        return $this->app_success($rs);
    }
}
