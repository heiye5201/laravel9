<?php

namespace Tests\Unit;

use App\Services\Redis\RedisService;
use Illuminate\Support\Facades\Cache;
use PHPUnit\Framework\TestCase;

class RedisTest extends TestCase
{

    /**
     * php artisan test --filter test_example tests/Unit/RedisTest.php
     * A basic unit test example.
     * @test
     * @return void
     */
    public function test_example()
    {
        $data = app(RedisService::class)->listenRedisLog();
        print_r(['data'=>$data]);
        $this->assertTrue(true);
    }


    /**
     * php artisan test --filter test_set tests/Unit/RedisTest.php
     * A basic unit test example.
     * @test
     * @return void
     */
    public function test_set()
    {
        // $res = Cache::add('key', 'value', 20*60); // 仅在键不存在时添加缓存
        $res = app(RedisService::class)->setData('username', 'jwj');
        print_r(['data'=>$res]);
    }
}
