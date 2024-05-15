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

//Route::any('/set_lang', [App\Http\Controllers\Auth\AuthController::class,'set_lang']);
//Route::post('/uploads', [App\Http\Controllers\Home\UploadsController::class,'upload'])->name('home.uploads');
//Route::post('/sms', [App\Http\Controllers\Home\SmsController::class,'send'])->name('home.sms'); // 短信发送
//Route::get('/article/{type}', [App\Http\Controllers\Home\ArticlesController::class,'article'])->name('home.Article'); // 文章

//Route::get('/common', [App\Http\Controllers\Home\IndexController::class,'common'])->name('home.config.common');
//Route::get('/home', [App\Http\Controllers\Home\IndexController::class,'home'])->name('home.common.index'); // 首页信息
//Route::get('/stores', [App\Http\Controllers\Home\StoresController::class,'stores'])->name('home.stores.index'); // 店铺列表
//Route::get('/store/{id}', [App\Http\Controllers\Home\StoresController::class,'show'])->name('home.store.show'); // 无权限获取店铺信息
//Route::get('/goods', [App\Http\Controllers\Home\GoodsController::class,'goods'])->name('home.goods.index'); // 商品列表 | 搜索
//Route::get('/goods/{id}', [App\Http\Controllers\Home\GoodsController::class,'show'])->name('home.goods.show'); // 商品详情
//Route::get('/goods_comments/{id}', [App\Http\Controllers\Home\GoodsController::class,'goods_comments'])->name('home.goods.comments'); // 商品评论
//Route::get('/is_fav', [App\Http\Controllers\Home\FavoritesController::class,'is_fav'])->name('home.user.isfav'); // 是否收藏关注
//Route::get('/cart_count', [App\Http\Controllers\Home\CartsController::class,'count'])->name('home.cart.count'); // 统计购物车数量
//Route::get('/integral/home', [App\Http\Controllers\Home\IntegralController::class,'home'])->name('home.integral.home'); // 积分商城
//Route::get('/integral/class', [App\Http\Controllers\Home\IntegralController::class,'integral_class'])->name('home.integral.class');
//Route::get('/integral/goods', [App\Http\Controllers\Home\IntegralController::class,'index'])->name('home.integral.goods');
//Route::get('/integral/goods/{id}', [App\Http\Controllers\Home\IntegralController::class,'show'])->name('home.integral.show');
//Route::get('/seckills', [App\Http\Controllers\Home\SeckillsController::class,'index'])->name('home.seckills.index');


Route::middleware('auth:users')->namespace('Api')->group(function ($route) {
    Route::post('/auth/info', [App\Http\Controllers\Auth\AuthController::class,'info'])->name('home.auth.info');
    Route::post('/auth/edit', [App\Http\Controllers\Auth\AuthController::class,'edit'])->name('home.auth.edit');

    // 入驻
//    Route::post('/store/join', [App\Http\Controllers\Home\StoresController::class,'join'])->name('home.store.join');
//    Route::put('/store', [App\Http\Controllers\Home\StoresController::class,'edit'])->name('home.store.edit');
//    Route::get('/store', [App\Http\Controllers\Home\StoresController::class,'info'])->name('home.store.info');
//
//    Route::get('/user/default', [App\Http\Controllers\Home\IndexController::class,'default']); // 用户首页
//    Route::resource('/user/addresses', App\Http\Controllers\Home\AddressesController::class); // 收货地址
//    Route::get('/user/addresses/default/{id}', [App\Http\Controllers\Home\AddressesController::class,'set_default'])->name('home.address.default');
//    Route::resource('/user/comments', App\Http\Controllers\Home\CommentsController::class)->only(['update','index','store','show']);
//    Route::put('/auth/edit', [App\Http\Controllers\Auth\AuthController::class,'edit'])->name('home.auth.edit'); // 编辑用户信息
//    Route::post('/user/check', [App\Http\Controllers\Home\UserChecksController::class,'edit'])->name('home.user.check.edit');
//    Route::get('/user/check', [App\Http\Controllers\Home\UserChecksController::class,'check'])->name('home.user.check');
//    Route::resource('/user/cashes', App\Http\Controllers\Home\CashesController::class)->only(['store','index']); // 提现
//    Route::resource('/user/favorites', App\Http\Controllers\Home\FavoritesController::class)->only(['store','index','destroy']);
//    Route::resource('/user/money_logs', App\Http\Controllers\Home\MoneyLogsController::class)->only(['index']);
//    Route::resource('/user/carts', App\Http\Controllers\Home\CartsController::class)->except(['show']);
//    Route::get('/user/orders', [App\Http\Controllers\Home\OrdersController::class,'orders'])->name('home.orders');
//    Route::put('/user/order/{id}', [App\Http\Controllers\Home\OrdersController::class,'edit'])->name('home.orders.edit');
//    Route::get('/user/order/{id}', [App\Http\Controllers\Home\OrdersController::class,'show'])->name('home.orders.show');
//    Route::post('/user/order/before', [App\Http\Controllers\Home\OrdersController::class,'before'])->name('home.order.before');
//    Route::post('/user/order/create', [App\Http\Controllers\Home\OrdersController::class,'create'])->name('home.order.create');
//    Route::post('/user/order/after', [App\Http\Controllers\Home\OrdersController::class,'after'])->name('home.order.after');
//    Route::post('/user/order/pay', [App\Http\Controllers\Home\OrdersController::class,'pay'])->name('home.order.pay');
//    Route::post('/user/order/check', [App\Http\Controllers\Home\OrdersController::class,'check'])->name('home.order.check');
//    Route::post('/user/order/express', [App\Http\Controllers\Home\OrdersController::class,'express'])->name('home.order.express');
//    Route::resource('/user/order/refund', App\Http\Controllers\Home\RefundsController::class)->only(['store','show','update']);
//    Route::resource('/user/coupons', App\Http\Controllers\Home\CouponsController::class)->only(['index']);
//    Route::post('/user/coupon/receive', [App\Http\Controllers\Home\CouponsController::class,'receive'])->name('home.coupon.receive'); // 领取优惠劵
//    Route::post('/integral/pay', [App\Http\Controllers\Home\IntegralController::class,'pay'])->name('home.integral.pay');
//    Route::get('/integral/orders', [App\Http\Controllers\Home\IntegralController::class,'integral_orders'])->name('home.integral.orders');
//    Route::get('/user/distributions', [App\Http\Controllers\Home\DistributionsController::class,'index'])->name('home.distribution.index');
//    Route::get('/user/distribution_logs', [App\Http\Controllers\Home\DistributionsController::class,'index'])->name('home.distribution_log.index');

});


/**
 *
 * @author hg <bishashiwo@gmail.com>
 * 在线聊天
 *
 */
Route::prefix('Chat')->namespace('Chat')->group(function () {
//    Route::post('/friends', [App\Http\Controllers\Chat\IndexController::class,'friends']);  // 好友列表
//    Route::post('/add', [App\Http\Controllers\Chat\IndexController::class,'add']);  // 互相关注好友
//    Route::post('/friend_content', [App\Http\Controllers\Chat\IndexController::class,'friend_content']); // 查看聊天内容
//    Route::post('/send', [App\Http\Controllers\Chat\IndexController::class,'send']);  // 发送信息
});

/**
 *
 * @author hg <bishashiwo@gmail.com>
 * 商城支付回调|其他回调 路由
 *
 */
Route::namespace('PayCallBack')->group(function () {
//    Route::any('/payment/{name}/{device}', [App\Http\Controllers\PayCallBack\PaymentController::class,'payment']); // 回调地址  [/api/payment/wechat/web] | [/api/payment/alipay/mini]
//    Route::any('/oauth/{name}', [App\Http\Controllers\PayCallBack\OauthController::class,'oauth']); // Oauth 第三方登录  [/api/oauth/weixin] | [/api/oauth/weixinweb] | [/api/oauth/github]
//    Route::any('/oauth/callback/{name}', [App\Http\Controllers\PayCallBack\OauthController::class,'oauthCallback']); // Oauth 第三方登录回调地址  [/api/oauth/callback/weixin|/api/callback/oauth/weixinweb] | [/api/payment/github]
});
