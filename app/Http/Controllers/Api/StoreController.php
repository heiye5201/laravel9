<?php
/**
 * autor      : jiweijian
 * createTime : 2024/6/15 22:10
 * description:
 */
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AdvService;
use App\Services\ConfigsService;
use App\Services\GoodsService;
use Illuminate\Http\Request;

class StoreController extends Controller
{

    public function getInfo(Request $request)
    {
        $data = [];
        $filter = ['web_name', 'description', 'logo'];
        $config = app(ConfigsService::class)->getKeyVal($filter);
        $data['storeInfo'] = $config['data'] ?? [];
        $data['client'] = 'H5';
        $data['setting'] = [
            'app_theme' => [
                'gradualChange'=>1, 'mainBg'=> '#FFA07A',//'#fa2209',
                'mainBg2'=>'#ff6335', 'mainText'=>'#ffffff',
                'viceBg'=>'#ffb100', 'viceBg2'=>'#ffb900', 'viceText'=> '#ffffff',
            ],
            'page_category_template' => [
                'style' => 20, 'shareTitle' => '全部分类', 'showAddCart' => true, 'cartStyle' => 1,
            ],
            'register' => [
                'registerMethod' => 10, 'isManualBind' => 1, 'isOauthMpweixin' =>1, 'isOauthMobileMpweixin'=>1,
            ],
            'customer' => [
                'enabled' => 1, 'provider' => 'mpwxkf', 'config' => ['mpwxkf'=>[]],
            ],
        ];
        $data['clientData'] = [
            'h5' => ['setting' => ['enabled'=>1, 'baseUrl' => 'jwj.test']]
        ];
        return $this->app_success($data);
    }


    public function homeDetail(Request $request)
    {
        $result = [
            'pageData' => [
                'page' => [
                    'params' => ['name' => '夜听雨', 'title' => '夜听雨商城', 'shareTitle'=> '分享标题'],
                    'style' => ['titleTextColor', 'titleBackgroundColor' => '#ffffff'],
                    'name' => '页面设置', 'type' => 'page',
                ],
                'items' => [
                    [
                        'name'=>'搜索框', 'type' => 'search',
                        'params' => ['placeholder'=> '请输入关键字进行搜索'],
                        'style' => ['textAlign' => 'left', 'searchStyle' => 'round'],
                    ],
                    [
                        'name' => '图片轮播', 'type' => 'banner',
                        'style' => ['btnColor' => '#d5a988', 'btnShape' => 'round', 'interval' => 20],
                        'data' => app(AdvService::class)->adv('wap_banner'),
                    ],
                    [
                        'name' => '店铺公告', 'type' => 'notice',
                        'params' => [
                            'text' => '夜听雨 致力于通过产品和服务，帮助商家高效化开拓市场。当前为演示商城，所有商品均为测试数据，请勿下单（不发货）。',
                            'link' => '', 'showIcon' => true, 'scrollable' => true,
                        ],
                        'style' => [
                            'paddingTop' => 1, 'background' => '#fffbe8', 'textColor' => '#de8c17',
                        ],
                    ],
                    [
                        'name' => '导航组', 'type' => 'navBar', 'style' => ['rowsNum'=>4, 'background' =>'#ffffff', 'paddingTop' =>3, 'textColor' => '#666666'],
                        'data' => [
                            [
                                'imgUrl' => 'http://static.yoshop.xany6.com/10001/20210315/8749305b19496b7b5b0b098837357a80.png', 'imgName'=> '', 'text' => '居家生活',
                                'link' => [
                                    'title' => '商品列表页', 'type' => 'PAGE', 'param' => [
                                        'path' => 'pages/goods/list',
                                        'query' => ['categoryId' => 1, 'search' => ''],
                                    ],
                                ],
                            ],
                            [
                                'imgUrl' => 'http://static.yoshop.xany6.com/10001/20210315/003ebfff145bd74289b8ad5510b6a01e.png', 'imgName'=> '', 'text' => '手机数码',
                                'link' => [
                                    'title' => '手机数码', 'type' => 'PAGE', 'param' => [
                                        'path' => 'pages/goods/list',
                                        'query' => ['categoryId' => 2, 'search' => ''],
                                    ],
                                ],
                            ],
                            [
                                'imgUrl' => 'http://static.yoshop.xany6.com/10001/20210315/7a5fde286eb3c79e80be0b3f82f2079b.png', 'imgName'=> '', 'text' => '运动户外',
                                'link' => [
                                    'title' => '运动户外', 'type' => 'PAGE', 'param' => [
                                        'path' => 'pages/goods/list',
                                        'query' => ['categoryId' => 3, 'search' => ''],
                                    ],
                                ],
                            ],
                            [
                                'imgUrl' => 'http://static.yoshop.xany6.com/10001/20210315/49251b6557e20faee7c67d9ee331a98b.png', 'imgName'=> '', 'text' => '领券中心',
                                'link' => [
                                    'title' => '领券中心', 'type' => 'PAGE', 'param' => [
                                        'path' => 'pages/coupon/index',
                                    ],
                                ],
                            ]
                        ],
                    ],
                    [
                        'name' => '店主推荐', 'type' => 'image', 'style'=> ['paddingTop'=>0, 'paddingLeft'=> 0, 'background'=>'#ffffff'],
                        'data' => [
                            ['imgUrl' => 'http://static.yoshop.xany6.com/10001/20210314/0e7f6417ccccc90cf48f1359ea85ecc9.png', 'link' => '', 'imgName' => ''],
                            ['imgUrl' => 'http://static.yoshop.xany6.com/10001/20210314/a33f3214d24b6268d0262dcb16a93fd2.png', 'imgName' => '',
                                'link' => ['title' => '商品列表', 'type' => 'PAGE', 'param' => ['path' => 'pages/goods/list', 'query' => ['categoryId'=>133]]],
                            ],
                        ],
                    ],
                    [
                        'name' => '商品标题', 'type' => 'image', 'style'=> ['paddingTop'=>3, 'paddingLeft'=> 0, 'background'=>'#ffffff'],
                        'data' => [
                            ['imgUrl' => 'http://static.yoshop.xany6.com/10001/20210314/aefe0a60bb4c59c88a1d463bbe6b5198.png', 'link' => '', 'imgName' => ''],
                        ],
                    ],
                    [
                        'name' => '商品组', 'type' => 'goods', 'params'=> ['source'=>'auto','auto' => ['category'=>0,'goodsSort'=>'all','showNum'=>20]],
                        'style'=>[
                            'background' => '#F6F6F6', 'display' => 'list', 'column'=>2, 'show'=> [
                                'goodsName', 'goodsPrice', 'linePrice', 'sellingPoint', 'goodsSales'
                            ],
                        ],
                        'data' => app(GoodsService::class)->getGoodsList(),
                    ]
                ],
            ],
        ];
        return $this->app_success($result);
    }


    public function getSettingData(Request $request)
    {
        $result = [
            'setting' => [
                'app_theme' => [
                    'gradualChange' => 1, 'mainBg' => '#fa2209', 'mainBg2' => '#ff6335',
                    'mainText' => '#ffffff', 'viceBg' => '#ffb100', 'viceBg2' => '#ffb900', 'viceText'=> '#ffffff',
                ],
                'page_category_template' => [
                    'style' => 20, 'shareTitle' => '全部分类', 'showAddCart' => true, 'cartStyle'=> 1,
                ],
                'points' => [
                    'points_name' => '积分','describe' => 'a) 积分不可兑现、不可转让,仅可在本平台使用;\nb)',
                ],
                'recharge' => [
                    'is_entrance' => 1, 'is_custom'=>1, 'describe' => '1. 账户充值仅限微信在线方式支付，充值金额实时到账；'
                ],
                'register' => [
                    'registerMethod' => 10,'isManualBind'=>1,'isOauthMpweixin'=>1,'isOauthMobileMpweixin'=>1,
                ],
                'customer' => [
                    'enabled'=>1,'provider'=>'mpwxkf','config'=> ['mpwxkf'=>[]],
                ],
            ],
        ];
        return $this->app_success($result);
    }

    public function getServiceList(Request $request)
    {
        $data = [
            'list' => [
                [
                    'service_id' => 10001,
                    'name' => '七天无理由退货',
                    'summary' => '满足相应条件时，消费者可申请7天无理由退货',
                ],
                [
                    'service_id' => 10003,
                    'name' => '48小时发货',
                    'summary' => '下单后48小时之内发货',
                ],
            ],
            'total' => 0,
        ];
        return $this->app_success($data);
    }
}