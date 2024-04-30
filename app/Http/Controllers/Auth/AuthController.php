<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    
    public function login(Request $request)
    {
        $rs = app(AuthService::class)->login($request->all(), false);
        return $this->handle($rs);
    }

    // 注册
    public function register(Request $request)
    {
        $rs = app(AuthService::class)->registers($request->all());
        return $this->handle($rs);
    }

    // 退出账号
    public function logout(Request $request)
    {
        $rs = app(AuthService::class)->logout($request->all());
        return $this->success($rs);
    }

}
