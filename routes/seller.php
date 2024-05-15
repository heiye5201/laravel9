<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/15 09:55
 * description:
 */
use Illuminate\Support\Facades\Route;


Route::prefix('Seller')->middleware('auth:users')->namespace('Seller')->group(function ($route) {
    $route->any('/auth/info', [App\Http\Controllers\Auth\AuthController::class,'info'])->name('admin.auth.info');
    $route->get('/load_menu', [App\Http\Controllers\Seller\MenusController::class,'loadMenu']);
    $route->post('uploads', [App\Http\Controllers\Seller\UploadsController::class,'upload'])->name('seller.uploads');
    $route->any('/auth/edit', 'AuthController@edit')->name('seller.auth.edit');

    $route->resource('goods_attrs', 'GoodsAttrsController');
    $route->resource('users', 'UsersController');
    $route->resource('roles', 'RolesController');

    $route->resource('goods', 'GoodsController');
    $route->resource('goods_brands', 'GoodsBrandsController');

    $route->resource('stores', 'StoresController');
    $route->get('store_classes', 'StoresController@store_classes');
    $route->resource('freights', 'FreightsController');
    $route->resource('cashes', 'CashesController')->except(['update']);
    $route->resource('money_logs', 'MoneyLogsController')->only(['index','show']);

    $route->resource('distributions', 'DistributionsController');
    $route->resource('distribution_logs', 'DistributionLogsController')->only(['index']);

    $route->resource('coupons', 'CouponsController');
    $route->resource('coupon_logs', 'CouponLogsController')->only(['index']);

    $route->resource('seckills', 'SeckillsController');
    $route->resource('collectives', 'CollectivesController');
    $route->resource('full_reductions', 'FullReductionsController');

});
