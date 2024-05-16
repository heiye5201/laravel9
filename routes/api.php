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

Route::any('/login', [App\Http\Controllers\Auth\AuthController::class,'login']);
Route::any('/logout', [App\Http\Controllers\Auth\AuthController::class,'logout']);
Route::any('/register', [App\Http\Controllers\Auth\AuthController::class,'register']);
Route::any('/set_lang', [App\Http\Controllers\Auth\AuthController::class,'set_lang']);

Route::namespace('Home')->group(function ($route) {
    $route->post('/uploads', 'NoticesController@upload')->name('home.uploads');
    $route->post('/sms', 'SmsController@send')->name('home.sms'); // 短信发送
    $route->get('/article/{type}', 'ArticlesController@article')->name('home.Article');// 文章

    $route->get('/common', 'IndexController@common')->name('home.config.common');
    $route->get('/home', 'IndexController@home')->name('home.common.home'); // 首页信息

    $route->get('/stores', 'StoresController@stores')->name('home.stores.index'); // 店铺列表
    $route->get('/stores/{id}', 'StoresController@show')->name('home.stores.show'); // 无权限获取店铺信息

    // TODO
    $route->get('/goods', 'GoodsController@goods')->name('home.goods.index'); // 商品列表 | 搜索
    $route->get('/goods/{id}', 'GoodsController@show')->name('home.goods.show'); // 商品详情
    $route->get('/goods_comments/{id}', 'GoodsController@goods_comments')->name('home.goods.comments'); // 商品评论

    $route->get('/is_fav', 'FavoritesController@is_fav')->name('home.user.is_fav'); // 是否收藏关注

    $route->get('/cart_count', 'CartsController@count')->name('home.cart.count'); // 统计购物车数量

    $route->get('/integral/home', 'IntegralController@home')->name('home.integral.home'); // 积分商城
    $route->get('/integral/class', 'IntegralController@integral_class')->name('home.integral.class');
    $route->get('/integral/goods', 'IntegralController@index')->name('home.integral.goods');
    $route->get('/integral/goods/{id}', 'IntegralController@show')->name('home.integral.show');

    $route->get('/seckills', 'SeckillsController@index')->name('home.seckills.index');
});


Route::middleware('auth:users')->namespace('Home')->group(function ($route) {
    Route::post('/auth/info', [App\Http\Controllers\Auth\AuthController::class,'info'])->name('home.auth.info');
    Route::put('/auth/edit', [App\Http\Controllers\Auth\AuthController::class,'edit'])->name('home.auth.edit');

    // 入驻
    $route->get('/store/join', 'StoresController@join')->name('home.store.join');
    $route->put('/store', 'StoresController@edit')->name('home.store.edit'); // 编辑用户信息
    $route->get('/store', 'StoresController@info')->name('home.store.info');

    $route->get('/user/default', 'IndexController@default'); //用户首页

    $route->resource('/user/addresses', 'AddressesController'); // 收货地址
    $route->get('/user/addresses/default/{id}', 'AddressesController@set_default')->name('home.address.default');

    $route->resource('/user/comments', 'CommentsController')->only(['update','index','store','show']);

    $route->post('/user/check', 'UserChecksController@edit')->name('home.user.check.edit');
    $route->get('/user/check', 'UserChecksController@check')->name('home.user.check');

    $route->resource('/user/cashes', 'CashesController')->only(['index','store']); // 提现

    $route->resource('/user/favorites', 'FavoritesController')->only(['store','index','destroy']);

    $route->resource('/user/money_logs', 'MoneyLogsController')->only(['index']);

    $route->resource('/user/carts', 'CartsController')->except(['show']);

    $route->get('/user/orders', 'OrdersController@orders')->name('home.orders');
    $route->put('/user/orders/{id}', 'OrdersController@edit')->name('home.orders.edit');
    $route->get('/user/orders/{id}', 'OrdersController@show')->name('home.orders.show');
    $route->post('/user/orders/before', 'OrdersController@before')->name('home.orders.before');
    $route->post('/user/orders/create', 'OrdersController@create')->name('home.orders.create');
    $route->post('/user/orders/after', 'OrdersController@after')->name('home.orders.after');
    $route->post('/user/orders/pay', 'OrdersController@pay')->name('home.orders.pay');
    $route->post('/user/orders/check', 'OrdersController@check')->name('home.orders.check');
    $route->post('/user/orders/express', 'OrdersController@express')->name('home.orders.express');

    $route->resource('/user/order/refund', 'RefundsController')->only(['store','show','update']);

    $route->resource('/user/coupons', 'CouponsController')->only(['index']);
    $route->post('/user/coupon/receive', 'CouponsController@receive')->name('home.coupon.receive'); // 领取优惠劵

    $route->post('/integral/pay', 'IntegralController@pay')->name('home.integral.pay');
    $route->get('/integral/orders', 'IntegralController@integral_orders')->name('home.integral.orders');

    $route->get('/user/distributions', 'DistributionsController@index')->name('home.distribution.index');
    $route->get('/user/distribution_logs', 'DistributionsController@index')->name('home.distribution_log.index');

});


/**
 * 在线聊天
 */
Route::prefix('Chat')->namespace('Chat')->group(function () {
//    Route::post('/friends', [App\Http\Controllers\Chat\IndexController::class,'friends']);  // 好友列表
//    Route::post('/add', [App\Http\Controllers\Chat\IndexController::class,'add']);  // 互相关注好友
//    Route::post('/friend_content', [App\Http\Controllers\Chat\IndexController::class,'friend_content']); // 查看聊天内容
//    Route::post('/send', [App\Http\Controllers\Chat\IndexController::class,'send']);  // 发送信息
});

/**
 * 商城支付回调|其他回调 路由
 */
Route::namespace('PayCallBack')->group(function () {
//    Route::any('/payment/{name}/{device}', [App\Http\Controllers\PayCallBack\PaymentController::class,'payment']); // 回调地址  [/api/payment/wechat/web] | [/api/payment/alipay/mini]
//    Route::any('/oauth/{name}', [App\Http\Controllers\PayCallBack\OauthController::class,'oauth']); // Oauth 第三方登录  [/api/oauth/weixin] | [/api/oauth/weixinweb] | [/api/oauth/github]
//    Route::any('/oauth/callback/{name}', [App\Http\Controllers\PayCallBack\OauthController::class,'oauthCallback']); // Oauth 第三方登录回调地址  [/api/oauth/callback/weixin|/api/callback/oauth/weixinweb] | [/api/payment/github]
});
