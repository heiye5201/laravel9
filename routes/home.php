<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/31 15:03
 * description:
 */

use Illuminate\Support\Facades\Route;

Route::any('/login', [App\Http\Controllers\Auth\AuthController::class,'login']);
Route::any('/logout', [App\Http\Controllers\Auth\AuthController::class,'logout']);
Route::any('/register', [App\Http\Controllers\Auth\AuthController::class,'register']);
Route::any('/set_lang', [App\Http\Controllers\Auth\AuthController::class,'set_lang']);

Route::namespace('Home')->name('home.')->group(function ($route) {
    $route->post('/uploads', 'UploadsController@upload')->name('uploads');
    $route->post('/sms', 'SmsController@send')->name('sms'); // 短信发送
    $route->get('/article/{type}', 'ArticlesController@article')->name('Article');// 文章

    $route->get('/common', 'IndexController@common')->name('config.common');
    $route->get('/home', 'IndexController@home')->name('common.home'); // 首页信息

    $route->get('/stores', 'StoresController@stores')->name('stores.index'); // 店铺列表
    $route->get('/stores/{id}', 'StoresController@show')->name('stores.show'); // 无权限获取店铺信息

    $route->get('/goods', 'GoodsController@goods')->name('goods.index'); // 商品列表 | 搜索
    $route->get('/goods/{id}', 'GoodsController@show')->name('goods.show'); // 商品详情
    $route->get('/goods_comments/{id}', 'GoodsController@goods_comments')->name('goods.comments'); // 商品评论

    $route->get('/is_fav', 'FavoritesController@is_fav')->name('user.is_fav'); // 是否收藏关注
    $route->get('/cart_count', 'CartsController@count')->name('cart.count'); // 统计购物车数量

    $route->get('/integral/home', 'IntegralController@home')->name('integral.home'); // 积分商城
    $route->get('/integral/class', 'IntegralController@integral_class')->name('integral.class');
    $route->get('/integral/goods', 'IntegralController@index')->name('integral.goods');
    $route->get('/integral/goods/{id}', 'IntegralController@show')->name('integral.show');

    $route->get('/seckills', 'SeckillsController@index')->name('seckills.index');

    $route->get('/store/{id}', 'StoresController@show')->name('store.show'); // 无权限获取店铺信息
});


Route::middleware('auth:users')->namespace('Home')->name('home.')->group(function ($route) {
    Route::post('/auth/info', [App\Http\Controllers\Auth\AuthController::class,'info'])->name('auth.info');
    Route::post('/auth/edit', [App\Http\Controllers\Auth\AuthController::class,'edit'])->name('auth.edit');

    // 入驻
    $route->post('/store/join', 'StoresController@join')->name('store.join');
    $route->put('/store', 'StoresController@edit')->name('store.edit'); // 编辑用户信息
    $route->get('/store', 'StoresController@info')->name('store.info');

    $route->get('/user/default', 'IndexController@default'); //用户首页

    $route->resource('/user/addresses', 'AddressesController'); // 收货地址
    $route->get('/user/addresses/default/{id}', 'AddressesController@set_default')->name('address.default');

    $route->resource('/user/comments', 'CommentsController')->only(['update','index','store','show']);

    $route->post('/user/check', 'UserChecksController@edit')->name('user.check.edit');
    $route->get('/user/check', 'UserChecksController@check')->name('user.check');

    $route->resource('/user/cashes', 'CashesController')->only(['index','store']); // 提现

    $route->resource('/user/favorites', 'FavoritesController')->only(['store','index','destroy']);

    $route->resource('/user/money_logs', 'MoneyLogsController')->only(['index']);

    $route->resource('/user/carts', 'CartsController')->except(['show']);

    $route->get('/user/orders', 'OrdersController@orders')->name('orders');
    $route->put('/user/order/{id}', 'OrdersController@edit')->name('orders.edit');
    $route->get('/user/order/{id}', 'OrdersController@show')->name('orders.show');
    $route->post('/user/order/before', 'OrdersController@before')->name('orders.before');
    $route->post('/user/order/create', 'OrdersController@create')->name('orders.create');
    $route->post('/user/order/after', 'OrdersController@after')->name('orders.after');
    $route->post('/user/order/pay', 'OrdersController@pay')->name('orders.pay');
    $route->post('/user/order/check', 'OrdersController@check')->name('orders.check');
    $route->post('/user/order/express', 'OrdersController@express')->name('orders.express');

    $route->resource('/user/order/refund', 'RefundsController')->only(['store','show','update']);

    $route->resource('/user/coupons', 'CouponsController')->only(['index']);
    $route->post('/user/coupon/receive', 'CouponsController@receive')->name('coupon.receive'); // 领取优惠劵

    $route->post('/integral/pay', 'IntegralController@pay')->name('integral.pay');
    $route->get('/integral/orders', 'IntegralController@integral_orders')->name('integral.orders');
    $route->get('/user/integral_order/{id}', 'IntegralController@orderInfo')->name('integral.orders.info');

    $route->get('/user/distributions', 'DistributionsController@index')->name('distribution.index');
    $route->get('/user/distribution_logs', 'DistributionLogsController@index')->name('distribution_log.index');
});

/**
 * 商城支付回调|其他回调 路由
 */
Route::namespace('PayCallBack')->group(function ($route) {
    $route->any('/payment/{name}/{device}', [App\Http\Controllers\PayCallBack\PaymentController::class,'payment']); // 回调地址  [/api/payment/wechat/web] | [/api/payment/alipay/mini]
    $route->any('/oauth/{name}', [App\Http\Controllers\PayCallBack\OauthController::class,'oauth']); // Oauth 第三方登录  [/api/oauth/weixin] | [/api/oauth/weixinweb] | [/api/oauth/github]
    $route->any('/oauth/callback/{name}', [App\Http\Controllers\PayCallBack\OauthController::class,'oauthCallback']); // Oauth 第三方登录回调地址  [/api/oauth/callback/weixin|/api/callback/oauth/weixinweb] | [/api/payment/github]
});