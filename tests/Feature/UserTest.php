<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    // php artisan test --filter 方法名 测试文件路径

    // php artisan test --filter test_example tests/Feature/UserTest.php
    // 动态规划篇小节
    // https://blog.csdn.net/weixin_38292570/article/details/108372575

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->post('/api/discount/info', ['id' => 1]);
        $response->dump();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_discount()
    {
        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->post('/api/discount/info_new', ['id' => 1]);
        $response->dump();
    }


    public function test_discount_page()
    {
        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->post('/api/discount/page', ['id' => 1]);
        $response->dump();
    }



    /**
     * {#706 // vendor/laravel/framework/src/Illuminate/Testing/TestResponse.php:1432
    +"n": 44
    +"result": 1134903170
    +"expenses_time": 63.156
    }
     */
    public function test_climb()
    {
        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->post('/api/match/climb_stairs', ['n' => 44]);
        $response->dump();
    }


    /**
     *
    root@23076cf9587c:/var/www/laravel_shop/laravel9_demo# php artisan test --filter test_climb_new tests/Feature/UserTest.php
    {#710 // vendor/laravel/framework/src/Illuminate/Testing/TestResponse.php:1432
    +"n": 44
    +"result": 1134903170
    +"expenses_time": 0
    }
     */
    public function test_climb_new()
    {
        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->post('/api/match/climb_stairs_new', ['n' => 44]);
        // 1134903170
        $response->dump();
    }



    public function test_optimal_match()
    {
        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->post('/api/match/optimal_match', ['n' => 44]);
        $response->dump();
    }


    /**
     * php artisan test --filter test_numeric tests/Feature/UserTest.php
     */
    public function test_numeric()
    {
        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->post('/api/match/numeric', ['n' => 44]);
        $response->dump();
    }


}
