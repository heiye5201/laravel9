<?php
/**
 * autor      : jiweijian
 * createTime : 2024/10/30 18:38
 * description:
 */
namespace Tests\Unit;

use Illuminate\Support\Facades\Storage;
use Tests\TestCase; // 更改继承的 TestCase 类
use Illuminate\Support\Facades\Http;

class CheckDiscountTest extends TestCase
{

    public $filterName = 'productData';

    /**
     * php artisan test --filter test_example tests/Unit/CheckDiscountTest.php
     * 获得数据
     * @test
     * @return void
     */
    public function test_example()
    {
        $response = Http::post('https://froehlich-keit.de/api/store/products/search', [
            'include_id' => [
                [
                    'product_id' => 25734
                ]
            ],
        ]);
        // 获取响应数据
        $data = $response->json();
        $variantsIds = [];
        collect($data['data'])->map(function ($item) use (&$variantsIds) {
            $variantsIds = collect($item['variants'] ?? [])->pluck('ID');
        });
        print_r(['data'=>count($variantsIds)]);
    }

    /**
     * php artisan test --filter testSave tests/Unit/CheckDiscountTest.php
     * 生成json文件
     * @test
     * @return void
     */
    public function testSave()
    {
        $data = $this->getSaveData($this->filterName);
        print_r(['data'=>$data]);
    }


    public function getSaveData($fileName)
    {
        $filePath = 'tests/'.$fileName.'.json';
        $savedData = json_decode(Storage::disk('local')->get($filePath), true);
        return collect($savedData)->map(function ($value) {
            $value['variants'] = json_decode($value['variants'], true);
            return $value;
        })->values();
    }


    public function initOldRuleData($filterName, $data)
    {
        // 将数据保存为 JSON 文件
        $filePath = 'tests/'.$filterName.'.json';
        if (Storage::disk('local')->exists($filePath)) {
            $savedData = json_decode(Storage::disk('local')->get($filePath), true);
            if (collect($savedData)->count() !== collect($data)->count()) {
                Storage::disk('local')->put($filePath, json_encode($data, JSON_PRETTY_PRINT));
            }
        } else {
            Storage::disk('local')->put($filePath, json_encode($data, JSON_PRETTY_PRINT));
        }
    }
}