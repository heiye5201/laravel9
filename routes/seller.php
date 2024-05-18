<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/15 09:55
 * description:
 */
use Illuminate\Support\Facades\Route;


Route::prefix('Seller')->middleware('auth:users')->name('seller.')->namespace('Seller')->group(function ($route) {
    $route->any('/auth/info', [App\Http\Controllers\Auth\AuthController::class,'info'])->name('auth.info');
    $route->get('/load_menu', [App\Http\Controllers\Seller\MenusController::class,'loadMenu']);
    $route->post('uploads', [App\Http\Controllers\Seller\UploadsController::class,'upload'])->name('uploads');
    $route->any('/auth/edit', 'AuthController@edit')->name('auth.edit');

    $route->resource('goods_attrs', 'GoodsAttrsController');
    $route->resource('users', 'UsersController');
    $route->resource('roles', 'RolesController');

    $route->resource('goods', 'GoodsController');
    $route->resource('goods_brands', 'GoodsBrandsController');

    $route->resource('stores', 'StoresController');
    $route->get('store_classes', 'StoresController@store_classes');
    $route->resource('freights', 'FreightsController');

    $route->resource('orders', 'OrdersController')->only(['index','show','update']);
    $route->resource('order_settlements', 'OrderSettlementsController')->only(['index','show']);
    $route->resource('order_comments', 'OrderCommentsController');

    $route->get('/orders/find/all', 'OrdersController@all')->name('seller.order.findall');
    $route->put('/orders/status/edit', 'OrdersController@edit')->name('seller.status.edit');

    $route->resource('cashes', 'CashesController')->except(['update']);
    $route->resource('money_logs', 'MoneyLogsController')->only(['index','show']);

    $route->resource('distributions', 'DistributionsController');
    $route->resource('distribution_logs', 'DistributionLogsController')->only(['index']);

    $route->resource('coupons', 'CouponsController');
    $route->resource('coupon_logs', 'CouponLogsController')->only(['index']);

    $route->resource('seckills', 'SeckillsController');
    $route->resource('collectives', 'CollectivesController');
    $route->resource('full_reductions', 'FullReductionsController');


    $route->get('/dashboard/all', 'DashboardController@all')->name('seller.dashboard.all'); // 仪表盘
    $route->get('/dashboard/order', 'DashboardController@order')->name('seller.dashboard.order'); // 销售分析


});
