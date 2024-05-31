<?php

namespace Tests\Unit;

use App\Models\Solution;
use App\Services\Api\MatchService;
use App\Services\Discount\Processor\FilterProcessor;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\App;
use PHPUnit\Framework\TestCase;

class MatchTest extends TestCase
{
    use DatabaseTransactions;

    protected $connectionsToTransact = ["mysql"];

    // php artisan make:test UserTest --unit
    // php artisan test --filter 方法名 测试文件路径

    // php artisan test --filter test_example tests/Unit/MatchTest.php
    // 动态规划篇小节
    // https://blog.csdn.net/weixin_38292570/article/details/108372575

    /**
     * 爬楼梯
     *
     * @return void
     */
    public function test_example()
    {
        $data = []; //app(MatchService::class)->climbStairs(6);
        print_r(['data'=>$data]);
        $this->assertTrue(true, 'success');
    }


    /**
     * 爬楼梯2
     *
     * @return void
     */
    public function test_example2()
    {
        $data = [];// app(MatchService::class)->climbStairsNew(6);
        print_r(['data'=>$data]);
        $this->assertTrue(true, 'success');
    }


    /**
     * 打家劫舍
     * https://blog.csdn.net/weixin_38292570/article/details/108372575
     * https://leetcode.cn/problems/house-robber/
     * @return void
     */
    public function getOptimalMatch()
    {
        $houses = array(1,2,3,1,6,2);
        $data = app(MatchService::class)->optimalMatch($houses);
        print_r(['data'=>$data]);
        $this->assertTrue(true, 'success');
    }


    /**
     * 阶梯子和
     * @return array
     */
    public function runningSum()
    {
        $solution = new Solution([5,3,6,9,12,7,2]);
        return $solution->runningSum();
    }

}
