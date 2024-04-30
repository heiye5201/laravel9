<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Laravel\Passport\Passport;

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
            $authModel = new \App\Models\Admins();
            if ($provider !== 'admins') $authModel = $authModel->orWhere('phone', $username);
            $authModel = $authModel->orWhere('username', $username)->first();
            $authModel->last_login_time = !empty($authModel->login_time) ? $authModel->login_time : now();
            $authModel->login_time = now();
            $authModel->save();
            if (request('form')) {
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

    }


    public function logout($data)
    {
        $provider = $data['provider'] ?? '';// users | admins
        if (auth($provider)->check()) {
            auth($provider)->user()->token()->delete();
        }
        return true;
    }
}