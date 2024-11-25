<?php
/**
 * autor      : jiweijian
 * createTime : 2024/10/31 10:38
 * description:
 */
namespace Tests\Unit;

use App\Imports\DiscountImport;
use App\Imports\OrderImport;
use Tests\TestCase; // 更改继承的 TestCase 类
use Maatwebsite\Excel\Facades\Excel;

class CheckBuyDiscountTest extends TestCase
{

    public $filterName = 'discount.xlsx';

    /**
     * php artisan test --filter checkHaveProblemOrderByGift tests/Unit/CheckBuyDiscountTest.php
     * 获得数据
     * @test
     * @return void
     */
    public function checkHaveProblemOrderByGift()
    {
        //获得所有满送折扣数据
        $import = new DiscountImport();
        Excel::import($import, storage_path('app/discount.xlsx'));
        $ruleData = $import->collection;
        $import = new OrderImport();
        // 获得所有使用了满送的订单商品数据
        Excel::import($import, storage_path('app/order.xlsx'));
        $secondSheetData = $import->sheets()[1]->collection;
        // 获得赠品数据
        $secondSheetData = collect($secondSheetData)->where('coupon_amount', '>', 0);
        $exitOrderProduct = [];
        $specialOrderProduct = [];
        foreach ($secondSheetData as $item) {
            // 根据店铺 和规则id 获得该赠品的生效的折扣数据
            $ruleInfo = collect($ruleData)->where('store_name', $item['store_name'])
                ->where('id', $item['rule_id'])->first();
            if ($ruleInfo) {
                $adjustments = json_decode($ruleInfo['buy_x_get_y_adjustments'], true);
                // 检查赠品的所有变种数据
                $productVariants = collect($adjustments['ranges'] ?? [])->map(function ($item) {
                    $productVariants = collect(json_decode($item['product_variants'], true));
                    return $productVariants->flatMap(function ($item) {
                        return $item;
                    })->values()->all();
                })->collapse()->toArray();
                // 检查优惠的赠品是否存不是该折扣的赠品的数据
                if ($productVariants && !in_array($item['variation_id'], $productVariants)) {
                    $exitOrderProduct[] = $item;
                }
                // 特殊赠品数据
                if (empty($productVariants)) {
                    $specialOrderProduct[] = $item;
                }
            } else {
                $exitOrderProduct[] = $item;
            }
        }
        print_r(['data'=>collect($exitOrderProduct)->take(100), 'special'=>$specialOrderProduct]);
    }


    // 组合字段判断，用二进制的方式可以进行快速的组合与比对


    const DISCOUNT_TYPE_PRODUCT = 'product';
    const DISCOUNT_TYPE_CART = 'cart';
    const DISCOUNT_TYPE_SHIPPING = 'shipping';


    public static $ruleTypeMap = [
        self::DISCOUNT_TYPE_PRODUCT => self::COMBING_PRODUCT,
        self::DISCOUNT_TYPE_CART => self::COMBING_CART,
        self::DISCOUNT_TYPE_SHIPPING => self::COMBING_SHIPPING,
    ];

    const COMBING_PRODUCT = 1; // 二进制 001
    const COMBING_CART = 0; // 二进制 010
    const COMBING_SHIPPING = 4; // 二进制 100

    /**
     * 分组后形成的数组类似： ['combining'=>可叠加数组，'individual'=>不可叠加的数组]
     * php artisan test --filter check tests/Unit/CheckBuyDiscountTest.php
     * 获得数据
     * @test
     * @return void
     */
    public function check()
    {
        $combining = 1;
        $adjustment['combining_result'] = $combining & self::$ruleTypeMap['cart'] ? '可叠加数组' : '不可叠加的数组';
        print_r(['data'=>$adjustment]);
    }
}
