<?php
/**
 * autor      : jiweijian
 * createTime : 2024/10/16 15:18
 * description:
 */
namespace Tests\Feature\Modules\Array;

use Tests\TestCase;

class ArrayTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * 检查满送变种商品数据同步
     * php artisan test --filter testIndex tests/Feature/Modules/Array/ArrayTest.php
     * @test
     * @return void
     */
    public function testIndex()
    {
        $errorAmount =  (string) $this->options[0]['amount']['value'] ?? '0';
        $configAmount =  (string) ($this->options[0]['amount']['value'] ?? '0');
        print_r(['error'=>$errorAmount, 'config'=>$configAmount]);
    }
}