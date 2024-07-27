<?php
/**
 * autor      : jiweijian
 * createTime : 2024/7/26 23:57
 * description:
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class OrderController extends Controller
{

    public function todoCounts()
    {
        $rs = [
            'counts'=> [
                'delivery' => 0,
                'payment' => 0,
                'received' => 0,
                'refund' => 0,
            ]
        ];
        return $this->app_success($rs);
    }
}