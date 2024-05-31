<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/31 15:00
 * description:
 */
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\RedisService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TestController extends Controller
{
    protected $redisService;
    public function __construct(RedisService $redisService)
    {
        $this->redisService = $redisService;
    }

    public function testRedis(Request $request)
    {
        $data = $this->redisService->deleteTag();
        return $this->app_success(['dd'=>$data]);
    }

}