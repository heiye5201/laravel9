<?php
/**
 * autor      : jiweijian
 * createTime : 2024/6/16 09:44
 * description:
 */
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function getList(Request $request)
    {
        $data = [
            'list' => [
                [
                    'category_id' => '122',
                    'name' => '手机数码',
                    'parent_id' => 0,
                    'status' => 1,
                    'sort' => 50,
                    'image'=> [
                        'preview_url' => 'https://static.yoshop.xany6.com/201809281707400fb788198.png',
                        'external_url' => 'https://static.yoshop.xany6.com/201809281707400fb788198.png'
                    ],
                    'children' => [
                        [
                            'category_id' => 1232,
                            'name' => '小米',
                            'parent_id' => 122,
                            'sort' => 32,
                            'status' => 1,
                            'image' => [
                                'preview_url' => 'https://static.yoshop.xany6.com/201807171021031720f9679.png',
                                'external_url' => 'https://static.yoshop.xany6.com/201807171021031720f9679.png',
                            ],
                        ],
                        [
                            'category_id' => 1232,
                            'name' => '华为',
                            'parent_id' => 122,
                            'sort' => 32,
                            'status' => 1,
                            'image' => [
                                'preview_url' => 'https://static.yoshop.xany6.com/20180717102129b4e214214.jpg',
                                'external_url' => 'https://static.yoshop.xany6.com/20180717102129b4e214214.jpg',
                            ],
                        ]
                    ],
                ]
            ]
        ];
        return $this->app_success($data);
    }
}