<?php

namespace Tests\Feature\Modules\Discount\Services\EntireProcess;

use Maatwebsite\Excel\Facades\Excel;
use Tests\Feature\Modules\Discount\Services\EntireProcess\Imports\OldBulkRule;
use Tests\TestCase;

class CheckOldBulkRuleValueType extends TestCase
{

    /**
     * phpunit --filter testGenerate tests/Feature/Modules/Discount/Services/EntireProcess/CheckOldBulkRuleValueType.php
     * 普通折扣-指定分类-满200-打折
     *
     * @return void
     */
    public function testGenerate()
    {
        Excel::import(new OldBulkRule(), storage_path('app/Excel').'/wf_datawarehouse_ods_wp_v2_wp_wdr_rules.xlsx');
    }
}
