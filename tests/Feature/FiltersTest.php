<?php

namespace Tests\Feature;

use App\Services\Discount\Processor\FilterProcessor;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class FiltersTest extends TestCase
{
    use DatabaseTransactions;

    protected $connectionsToTransact = ["mysql"];

    // php artisan test --filter testGenerate tests/Feature/FiltersTest.php
    public function testGenerate()
    {
        $service  = App::make(FilterProcessor::class);
        $cartData = [
            'cart'=>[
                [
                    'collection'=>[1,2],
                    'product_id'=>46789,
                    'variation_id'=>21
                ],
                [
                    'collection'=>[3,5],
                    'product_id'=>91593,
                    'variation_id'=>265
                ],
                [
                    'collection'=>[3,5],
                    'product_id'=>32560,
                    'variation_id'=>28
                ],
                [
                    'collection'=>[3,41888],
                    'product_id'=>352,
                    'variation_id'=>28
                ],
                [
                    'collection'=>[3,5],
                    'product_id'=>55,
                    'variation_id'=>28
                ],
                [
                    'collection'=>[3,5],
                    'product_id'=>59,
                    'variation_id'=>28
                ],
                [
                    'collection'=>[3,5],
                    'product_id'=>93,
                    'variation_id'=>28
                ],
                [
                    'collection'=>[3,5],
                    'product_id'=>593,
                    'variation_id'=>28
                ],
                [
                    'collection'=>[3,5],
                    'product_id'=>9151,
                    'variation_id'=>28
                ],
                [
                    'collection'=>[3,5],
                    'product_id'=>915,
                    'variation_id'=>28
                ]
            ],
//            'rule_codes'=>['PDMJUN','ODJFMS'],
        ];
        $result = $service->process($cartData);
        print_r(['count'=>count($result)]);
        $this->assertTrue(true, 'test');
    }
}
