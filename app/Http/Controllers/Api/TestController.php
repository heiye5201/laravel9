<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/31 15:00
 * description:
 */
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DiscountRuleFilter;
use App\Services\RedisService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\DiscountRuleImport;
use App\Models\DiscountRule;

class TestController extends Controller
{

    public function testImport(Request $request)
    {
        $filePath = storage_path('app/discount_rule_import_test.xlsx');
//        Excel::import(new DiscountRuleImport, $filePath);
        return $this->app_success(['dd'=>$filePath]);
    }


    public function addFilter(Request $request)
    {
        DiscountRule::query()->where('id', '>', 0)->chunk(100, function ($ruleData) {
            $ruleArray = [];
            foreach ($ruleData as $rule) {
                $filter = json_decode($rule['filters'], true);
                foreach ($filter['object_ids'] as $val) {
                    $ruleArray[] = [
                        'filter_type' => $filter['filter_type'],
                        'operator' => $filter['operator'],
                        'object_id' => $val,
                        'discount_rule_id' => $rule['id'],
                        'main_product' => 0,
                        'is_code' => 0,
                    ];
                }
            }
            DiscountRuleFilter::query()->insert($ruleArray);
        });
        return $this->app_success(['dd'=>'test']);
    }


    public function addBuyFitter(Request $request)
    {
        DiscountRule::query()->where('discount_type', 'buy_x_get_y_discount')->chunk(100, function ($ruleData) {
            $ruleArray = [];
            foreach ($ruleData as $rule) {
                $groups = json_decode($rule['adjustments'], true)['adjustment_group'] ?? [];
                $filter = json_decode($rule['filters'], true);
                foreach ($groups['adjustment_group'] as $val) {
                    $ruleArray[] = [
                        'filter_type' => $filter['filter_type'],
                        'operator' => $filter['operator'],
                        'object_id' => $val,
                        'discount_rule_id' => $rule['id'],
                        'main_product' => 0,
                        'is_code' => 0,
                    ];
                }
            }
            DiscountRuleFilter::query()->insert($ruleArray);
        });
        return $this->app_success(['dd'=>'test']);
    }
}
