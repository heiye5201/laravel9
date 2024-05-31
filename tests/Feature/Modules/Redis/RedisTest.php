<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/31 13:33
 * description:
 */
namespace Tests\Feature\Modules\Redis;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Cache;

class RedisTest extends TestCase
{
//    use DatabaseTransactions;
    public function setUp(): void
    {
        parent::setUp();
        // 清空所有缓存，确保测试环境干净
        Cache::flush();
    }
    // 生成测试：php artisan make:test Services/Discount/BulkDiscount/CollectionAmountPercentage

    // php artisan test --filter testBigKey tests/Feature/Modules/Redis/RedisTest.php
    //  php artisan test  tests/Feature/Modules/Redis/RedisTest.php

    public function testBigKey()
    {
        $tag = 'my-tag';
        $key1 = 'my-key1';
        $val1 = 'my-val1';
        $key2 = 'my-key2';
        $val2 = 'my-val2';
        Cache::tags($tag)->put($key1, $val1, 3600);
//        Cache::tags($tag)->put($key2, $val2, 3600);
        $data = Cache::tags($tag)->get($key1);
        print_r(['result' => 0, '$data'=>$data]);
        Cache::put('jwj', 'sdfsfsdfd');
    }

//    public function testLoginGetAccountOrder()
//    {
//        $user = Customer::first();
//        $response = $this->actingAs($user)
//            ->call('get', '/account/order/1');
//        $this->assertEquals(404, $response->status());
//    }
}