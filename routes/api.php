<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::namespace('Api')->name('api.')->group(function ($route) {
    $route->get('/test/import', 'TestController@testImport')->name('TestImport');
    $route->get('/test/addFilter', 'TestController@addFilter')->name('TestImport');

    $route->get('/app/store/data', 'StoreController@getInfo')->name('storeInfo');
    $route->get('/app/goods.service/list', 'StoreController@getServiceList')->name('getServiceList');

    $route->get('/app/home/detail', 'StoreController@homeDetail')->name('homeDetail');
    $route->get('/app/home/setting', 'StoreController@getSettingData')->name('getSettingData');
    $route->get('/app/category/list', 'CategoryController@getList')->name('getCategoryList');
    $route->get('/app/coupon/list', 'CouponController@getList')->name('getCouponList');

    $route->get('/app/goods/list', 'GoodsController@getList')->name('getGoodsList');
    $route->get('/app/goods/detail', 'GoodsController@getDetail')->name('getGoodsDetail');

    $route->get('/app/cart/list', 'CartController@getList')->name('getCartList');
    $route->get('/app/cart/total', 'CartController@getTotal')->name('getCartTotal');

    $route->get('/app/captcha/image', 'LoginController@getCaptcha')->name('getCaptcha');
    $route->post('/app/passport/login', 'LoginController@passLogin')->name('passLogin');

    $route->get('/app/user/info', 'UserController@getInfo')->name('getInfo');
    $route->get('/app/user/assets', 'UserController@getAssets')->name('getAssets');

    $route->get('/app/order/todoCounts', 'OrderController@todoCounts')->name('todoCounts');

    $route->get('/app/comment/listRows', 'CommentController@getListRows')->name('getCommentListRows');

});

