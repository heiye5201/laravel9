<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

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


    public function info(Request $request)
    {
        $validated = $request->validate([
            'provider' => ['required',  Rule::in(['admins', 'users']),],
        ]);
        $prefix = $request->route()->action['prefix'];
        $rs = app(AuthService::class)->info($request->all(), $prefix);
        return $this->success($rs);
    }

    public function edit(Request $request)
    {
        $data = $request->except('provider');
        $id = $this->getUserId($request->provider);
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        if (isset($data['pay_password']) && !empty($data['pay_password'])) {
            $data['pay_password'] = Hash::make($data['pay_password']);
        }
        // 修改手机号码
        if (isset($data['phone']) && !empty($data['phone'])) {
            if (User::query()->whereNotIn('id', [$id])->where('phone', $data['phone'])->exists()) {
                return $this->error(__('tip.phoneExist'));
            }
//            $sms =  $this->getService('Sms')->checkSms($data['phone'], $data['code']);
//            if (!$sms['status']) {
//                return $this->error($sms['msg']);
//            } else {
//                unset($data['code']);
//            }
        }
        $rs = User::query()->where('id', $id)->update($data);
        return $this->success($rs);
    }
}
