<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\Request;

class LoginController extends Controller
{

    public function login(Request $request)
    {
        $request_data  = $request->all();
        $rs = app(AuthService::class)->login(false, $request_data['form']);
        return $this->app_success($rs);
    }

    // 注册
    public function register()
    {
        $rs = app(AuthService::class)->registerApp();
        return $this->app_handle($rs);
    }

    // 退出账号
    public function logout()
    {
        return $this->success(app(AuthService::class)->logout());
    }
}
