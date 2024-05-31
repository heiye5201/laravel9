<?php

namespace Tests\Unit;

use App\Services\Lefeng\QuestionService;
use PHPUnit\Framework\TestCase;

class QuestionTest extends TestCase
{
    // php artisan make:test QuestionTest --unit

    // php artisan test --filter test_example tests/Unit/QuestionTest.php

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $spuSkus = [
            [
                'spu' => '23ewesdf',
                'id' => 23,
                'skus' => [
                    [
                        'id' => 33,
                        'sku' => 'afdsf',
                        'team_id' => 21,
                        'kd_user_name' => '33r'
                    ],
                    [
                        'id' => 123,
                        'sku' => 'Odf334',
                        'team_id' => 23,
                        'kd_user_name' => 'ODed'
                    ]
                ]
            ],
        ];
        $data = []; //app(QuestionService::class)->testString3($spuSkus);
        print_r(['data'=>$data]);
        $this->assertTrue(true, 'success');
    }
}
