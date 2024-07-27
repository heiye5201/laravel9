<?php

namespace Tests\Feature;

use App\Imports\DiscountRuleImport;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;


class FiltersTest extends TestCase
{
    use DatabaseTransactions;

    protected $connectionsToTransact = ["mysql"];

    // php artisan test tests/Feature/FiltersTest.php
    public function testGenerate()
    {
        $filePath = storage_path('app/discount_rule_import.xlsx');
        Excel::import(new DiscountRuleImport, $filePath);
        $this->assertTrue(true, 'test');
    }
}
