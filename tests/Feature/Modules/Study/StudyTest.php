<?php
/**
 * autor      : jiweijian
 * createTime : 2024/11/26 18:00
 * description:
 */
namespace Tests\Feature\Modules\Study;

use App\Services\Study\NotificationStatusManager;
use Tests\TestCase;

class StudyTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * 学习
     * php artisan test --filter testStudy tests/Feature/Modules/Study/StudyTest.php
     * @test
     * @return void
     */
    public function testStudy()
    {
        $statusManager = app(NotificationStatusManager::class);
        // 根据传入的类型获取相应的状态处理服务
        $statusService = $statusManager->driver('product');
        // 处理状态
        $result =  $statusService->handleStatus(2122);
        print_r('test:'.$result);
    }
}