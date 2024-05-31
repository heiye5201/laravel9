<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{

    public function login(Request $request)
    {
        $request_data  = $request->all();
        $rs =  $this->getService('Auth')->login(false, $request_data['form']);
        return $this->app_success($rs);
    }

    // 注册
    public function register()
    {
        $rs = $this->getService('Auth')->registerApp();
        return $this->app_handle($rs);
    }

    // 退出账号
    public function logout()
    {
        return $this->success($this->getService('Auth')->logout());
    }

    // 第三方登录
    public function auth_login(){

        if(isset(request()->code)){
            $kuaibao_service = new KuaibaoService;
            $config_service = new ConfigService;
            $configInfo = $config_service->getFormatConfig('oauth')[request()->auth_name];
            $info = $kuaibao_service->http_send('https://api.weixin.qq.com/sns/jscode2session?appid='.$configInfo['client_id'].'&secret='.$configInfo['client_secret'].'&js_code='.request()->code.'&grant_type=authorization_code');
            $arr = json_decode($info->getContents(),true);
            return $this->success($arr);
        }
        $user_service = new UserService();
        $info = $user_service->oauthLogin(request()->all(),request()->oauth_name);
        return $info['status']?$this->success($info['data']):$this->error($info['msg']);
    }

    // 检测是否登陆
    public function check_login(Request $request){
        $info = $this->getUser($request->provider);
        if ($info['status']) {
            if (isset($info['data']['password'])) {
                unset($info['data']['password']);
            }
            if (isset($info['data']['pay_password'])) {
                unset($info['data']['pay_password']);
            }
        }
        return $this->handle($info);
    }

    // 找回密码
    public function forget_password(){
        $user_service = new UserService();
        $rs = $user_service->forgetPassword('phone');
        return $rs['status']?$this->success($rs['data'],$rs['msg']):$this->error($rs['msg']);
    }

    // 发送短信
    public function send_sms(Request $request){
        return $this->handle($this->getService('Sms')->sendSms($request->phone,$request->name));
    }
}
