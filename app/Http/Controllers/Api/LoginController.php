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


    public function getCaptcha()
    {
        $data = [
            'base64' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAANAAAABBCAMAAACXQNqgAAAAdVBMVEXz+/5PXFyg17GivJnPm+C3w96hyq/AuqzAu7if1rTcseDgwM6hq63K09Vjb3De5+mMl5i1v8F4g4SHi4SxrqJ5f3qfg65/c42WvKRZaWajopiVlo5jd3Brc3C4m7/Kps+Vhp6De41gZmxtiX13mYiBqJOLt56cBofxAAAACXBIWXMAAA7EAAAOxAGVKw4bAAAFQElEQVRoge2biXKkNhCGYWDQDMO93k3WzrGbzeb9HzHq1oEErQPQUJOq/EXhsY2FPvUlgZxlS10uWfZ4rH6cQvd7+JrrdT4n0OPxVJ4IoiuwJOPRQM8gApowEWe5puMB2+DxBCDBEuN1KRUCekid2qkjirPQfwooxgQvDVTa30JfQ0AvzZOVBJG/y6fy7EglC6Ig0Ln22Q5Urk3k9biT/c0HdLvNZ0JVNZ/dOjt+dgApC0UBhXnGIXTFJgWAxGFJexxHEYdPIaC2y/M2rquREhMmchZIA2lFAfnVTjnXdKAFLTHOcL4LHIKorvlR108DEjh50+9uwZACAgxhnzXQDWj4ydFEJQW1tixX9SmkpDiGhYDmx98j2SywOD1O5AM0ULmDKC2O6XLcNrzln1RacBpn3dguoCEZjg30D2+7pbLCM4FaftMtPG0zdFwT7UuiE6ro/+Rtk6k7GVBDZGZuougKNA5drtSNzl6oPvzAzOkGCnKFgLg1ulW0xJtozG25iLQ4feObzh0GGrAfw8JM0SZq0TDD2PZ9i02FxgFzwjOX7spfbDMpE3F/6iZvuoN0iCWxFn8VGIeQ7evYUHJpBMcXaTqfDDOBifpBOVLjbgAuxE7AqcGI94lf0XkvOArE+/Mpy94+oaEMoNYODfe4zz3kXemDPjdQsynG5vNBIOjBG4Om+OTAGrpJOuL45ZcFqy3tQ9gT35WojjJ3QqAGBky0lPVWV1rpgzydtN5Jqkht0vdDQD15AWMVHvD5IBAfsJExSWRrEiEF+fGLz5NUQlRZwetyI3kBvz8CFUVW1HWxDcESFCGgIYmEMOH7Bn5QQcSJptB6g8wJFQJljLMUAHSAiHfms+G/lBCo81TMUWW2uh6CIUTWt4oJIcsxlxNx7/w1YyUq8y1dISz+4F///Nb5E7y84Xpkqkp6iSxn+9VP/vkK3Acs5A8NzvH92/e/QgULb0ibENc5cDribfIOTecpMzxSAejXr94JgC6/eRd6AqHdcyG5GE0ABDfpnESYetj7V3/uUvPTKTgxpcuqoSRAwvHIsWXv/fvHb9DZD9/fA4y9CIEXbZS2LEsOqO/UwNlPVSqmfOnDndYzKtJdQDHrixSSc8qiEEAFin94Ezife0+dyqhxdwBtXQnvlqzfpgdroN+bN+YrvBlVLTnQhYCCgaMWyGnUzmMlk09RaZcTbCIp6GmWs6XVwCPNmkjmQ1gPHu39Wk3e6U5MYojB5QSJtBVOSRgLWWgdGoJlRTQneEgjaaMJRlURjbIiYgwBi/K92CevqyByAPH8Mw6TRtrdeVI4WvAooQfPxhgQSUEmBFAs0LAMIicQCp56hRfrm9WYK1L06RnIgIrRagLgiCFDfZs+O7Ta+HLKooA2t8RL62RlBUeWe7paNL1+3iOe7++ZfpxSXCJl9MXKcP/rWUq8Re1cXajIS7tF7VQ5cuM15Ra144opAeY7fSI5vhhPRJ7x77p4KQsFMie+Eb8LltuNrl4vFkN+C93lVk8JRMWQL8uJZ1InyxtDem/J7SZ4AjMmS5ey5BefTRSykDzvALoAyukTrHAMyTM4XXBKawtt80wiakNoEMjaLk0WVqcOW+iG0t+u2iI3QwVdLmZDu0MHY2hZLOKAnEkBN6kffH1sZLm7Y5eXR8u6RwFt2AWO1fL4+3CzF1tbM1zugku4xe8fYhdyZGuJZtFGL/aNDhKJdETHoyCC7OB/VBQNVEstf473P8Izx5C3YOidyAFbbbQQ8eLoYiVFgodOseI/TOC+2uUcQMo28hNbE5kQMUD/AmznMRt1eO1cAAAAAElFTkSuQmCC',
            'key' => '$2y$10$69stAHvVAXj.XlqkutObnebCvch1Z12.ELRSsXz8ujwwunySu93ZO',
            'md5' => 'd84b084b8a9fc9048f62f0c7f7db2075',
        ];
        return $this->app_success($data);
    }

    public function passLogin(Request $request)
    {
        $requestData  = $request->all();
//        $rs = app(AuthService::class)->login($requestData['form']);
        $rs = [
            'token' => '3a57c66576c14409fa839d5c90e31c8f',
            'userId' => 8
        ];
        return $this->app_success($rs);
    }
}
