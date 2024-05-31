<?php

namespace App\Http\Controllers\PayCallBack;

use App\Http\Controllers\Controller;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    // 回调处理
    public function payment($name, $device)
    {
        return app(PaymentService::class)->payment($name, $device);
    }
}
