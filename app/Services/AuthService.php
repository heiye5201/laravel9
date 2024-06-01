<?php
namespace App\Services;

use App\Models\Admins;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class AuthService extends BaseService
{
    
    public function login($loginData, $apiLogin = false)
    {
        $provider = $loginData['provider'] ?? 'users'; // 用户类型 User Admin
        $grantType = $loginData['grant_type'] ?? 'password'; // 登录方式
        $clientType = $loginData['client_type'] ?? 'password_client'; // 客户端类型默认密码类型得会过期
        $username = $loginData['username'] ?? '';
        $password = $loginData['password'] ?? '';
        $where = ['password_client' => 1, 'personal_access_client' => 0, 'provider' => $provider];
        // 个人客户端无限时间
        if ($clientType == 'personal_access_client') {
            $where['password_client'] = 0;
            $where['personal_access_client'] = 1;
        }
        $client = DB::table('oauth_clients')
            ->select('id', 'secret', 'user_id', 'redirect')
            ->where($where)
            ->first();
        if (!$client) {
            return $this->formatError(__('tip.oauthThr'));
        }
        $respData = [
            'grant_type'    =>  $grantType,
            'client_id'     =>  $client->id,
            'client_secret' =>  $client->secret,
            'username'      =>  $username,
            'password'      =>  $password,
            'scope'         =>  '',
        ];
        try {
            $resp = Http::asForm()->post(url('oauth/token'), $respData);
        } catch (\Exception $e) {
            if (empty($e->getCode())) $resp = Http::asForm()->post('nginx/oauth/token', $respData);
        }
        if ($resp->getStatusCode() == 200) {
            // 登录成功修改登录时间
            if ($provider !== 'admins') {
                $authModel = new User();
            } else {
                $authModel = new Admins();
            }
            if ($provider !== 'admins') $authModel = $authModel->orWhere('phone', $username);
            $authModel = $authModel->orWhere('username', $username)->first();
            $authModel->last_login_time = !empty($authModel->login_time) ? $authModel->login_time : now();
            $authModel->login_time = now();
            $authModel->save();
            if (isset($loginData['form']) && $loginData['form']) {
                $data = $resp->json();
                $data['userId'] = $authModel->id;
                $data['token'] = $data['access_token'];
                return $data;
            } else {
                return $this->format($resp->json());
            }
        }
        return $this->formatError($resp->json()['message'], $respData);
    }


    public function registers($data)
    {
        $username = $data['username'] ?? '';
        $password = $data['password'] ?? '';
        $type = $data['type'] ?? 'username'; // 注册方式 phone email
        $provider = $data['provider'] ?? 'users'; // 用户类型 users | admins
        if ($provider == 'admins') {
            return [];
        }
        $model = new User();
        // 判断是否存在相同得账号和电话
        if ($model->where($type, $username)->exists()) {
            // 该账号已经存在
            return $this->formatError(__('tip.userExist'));
        }
        $regData = [
            'nickname'  =>  $username,
            'username'  =>  $username,
            'phone'     =>  $type == 'phone' ? $username : '',
            'email'     =>  $type == 'email' ? $username : '',
            'password'  =>  Hash::make($password),
            'pay_password'  =>  Hash::make('123456'),
            'belong_id' =>  0,
        ];
        $type == 'phone' ? $regData['email'] = $regData['phone'].'@139.com':'';
        if (isset($data['inviter_id']) && $data['inviter_id']) {
            $regData['inviter_id'] = $data['inviter_id'];
        }
        if (!$model->create($regData)) {
            return []; // 账号建立失败
        }
        return $this->login(['username' => $username, 'password' => $password, 'provider' => $provider]);
    }


    public function logout($data)
    {
        $provider = $data['provider'] ?? '';// users | admins
        if (auth($provider)->check()) {
            auth($provider)->user()->token()->delete();
        }
        return true;
    }


    // 获取用户信息
    public function info($data, $prefix)
    {
        $info = $this->getUser($data['provider']);
        if ($info['status']) {
            if (isset($info['data']['password'])) {
                unset($info['data']['password']);
            }
            if (isset($info['data']['pay_password'])) {
                unset($info['data']['pay_password']);
            }
        }
        $pro = lcfirst(str_replace('api/', '', $prefix));
        if ($data['provider'] != 'users') {
            $info['data']['prefix'] = $pro;
            $info['data']['defaultUrl'] = '/Admin/admins';
        }
        return $info['data'] ?? [];
    }
}