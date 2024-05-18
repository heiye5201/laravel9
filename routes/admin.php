<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/15 09:55
 * description:
 */

use Illuminate\Support\Facades\Route;

Route::get('/load_article_menu', [App\Http\Controllers\Admin\ArticleMenusController::class,'loadMenu']);
Route::get('/load_goods_classes', [App\Http\Controllers\Admin\GoodsClassesController::class,'loadMenu'])->name('base.loadMenu');
Route::get('/load_areas', [\App\Http\Controllers\Admin\AreasController::class, 'loadArea'])->name('base.loadAreas');
Route::get('/expresses', [App\Http\Controllers\Admin\ExpressesController::class,'index'])->name('base.expresses'); // 物流公司

Route::prefix('Admin')->middleware('auth:admins')->name('admin.')->namespace('Admin')->group(function ($route) {
    $route->any('/auth/info', [App\Http\Controllers\Auth\AuthController::class,'info'])->name('auth.info');
    $route->any('/load_menu', [App\Http\Controllers\Admin\MenusController::class,'loadMenu']);

    $route->get('/notices', 'NoticesController@index')->name('notices.index');
    $route->get('/notices/{id}', 'NoticesController@show')->name('notices.info');
    $route->post('/notices',  'NoticesController@store')->name('notices.store');
    $route->put('/notices/{id}',  'NoticesController@update')->name('notices.update');
    $route->delete('/notices/{id}', 'NoticesController@destroy')->name('notices.destroy');

    $route->get('/article_menus', [App\Http\Controllers\Admin\ArticleMenusController::class,'index']);
    $route->get('/article_menus/{id}', [App\Http\Controllers\Admin\ArticleMenusController::class,'show']);
    $route->post('/article_menus', [App\Http\Controllers\Admin\ArticleMenusController::class,'store']);
    $route->put('/article_menus/{id}', [App\Http\Controllers\Admin\ArticleMenusController::class,'update']);
    $route->delete('/article_menus/{id}', [App\Http\Controllers\Admin\ArticleMenusController::class,'destroy']);

    $route->resource('articles', 'ArticlesController');
    $route->resource('goods_classes', 'GoodsClassesController');
    $route->post('uploads', 'UploadsController@upload')->name('uploads');
    $route->resource('goods_brands', 'GoodsBrandsController');
    $route->resource('goods', 'GoodsController');

    $route->resource('orders', 'OrdersController');
    $route->post('/orders/express/find', 'OrdersController@express')->name('order.express');
    $route->post('/orders/find/all', 'OrdersController@all')->name('order.findall');
    $route->post('/orders/status/edit', 'OrdersController@applyStatus')->name('order.applyStatus');

    $route->resource('order_comments', 'OrderCommentsController');

    $route->resource('order_settlements', 'OrderSettlementsController')->only(['index','show']); // 结算订单
    $route->get('order_settlement_handle', 'OrderSettlementsController@handle_sett')->name('admin.order.settl.handle'); // 结算订单

    $route->get('configs', 'ConfigsController@index')->name('configs');
    $route->put('configs/update', 'ConfigsController@edit')->name('configs.update');

    $route->resource('areas', 'AreasController');
    $route->resource('expresses', 'ExpressesController');
    $route->resource('integral_goods_classes', 'IntegralGoodsClassesController');
    $route->resource('integral_goods', 'IntegralGoodsController');

    $route->resource('admins', 'AdminsController');
    $route->resource('users', 'UsersController');
    $route->resource('roles', 'RolesController');
    $route->resource('menus', 'MenusController');

    $route->resource('permission_groups', 'PermissionGroupsController');
    $route->resource('permissions', 'PermissionsController');
    $route->get('load_permission', 'PermissionsController@loadPermission');

    $route->resource('sms', 'SmsController');
    $route->resource('sms_logs', 'SmsLogsController');

    $route->resource('adv_spaces', 'AdvSpacesController');
    $route->resource('advs', 'AdvsController');

    $route->resource('seller_menus', 'SellerMenusController');
    $route->get('load_seller_menu', 'SellerMenusController@loadMenu');
    $route->resource('agreements', 'AgreementsController');

    $route->resource('stores', 'StoresController');

    $route->resource('distribution_logs', 'DistributionLogsController')->only(['index']);

    $route->resource('integral_orders', 'IntegralOrdersController')->only(['index','show','update']);

});
