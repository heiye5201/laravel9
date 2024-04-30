<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
//         'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

//        Passport::loadKeysFrom(__DIR__.'/../secrets/oauth');

//        Passport::hashClientSecrets();
        // 令牌的有效期
        $this->passportConfig();

    }

    /**
     * passportConfig function
     *
     * @return void
     * @Description 令牌的有效期 配置
     * @Author hg <bishashiwo@gmail.com>
     * @Time 2021-09-21
     */
    public function passportConfig()
    {
        Passport::tokensExpireIn(now()->addDays(15));
        Passport::refreshTokensExpireIn(now()->addDays(30));
        Passport::personalAccessTokensExpireIn(now()->addMonths(6));
    }
}
