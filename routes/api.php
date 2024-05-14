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
Route::get('/load_article_menu', [App\Http\Controllers\Admin\ArticleMenusController::class,'loadMenu']);
Route::get('/load_goods_classes', [App\Http\Controllers\Admin\GoodsClassesController::class,'loadMenu'])->name('base.loadMenu');
Route::get('/load_areas', [\App\Http\Controllers\Admin\AreasController::class, 'loadArea'])->name('base.loadAreas');

Route::prefix('Admin')->middleware('auth:admins')->namespace('Admin')->group(function ($route) {
    $route->any('/auth/info', [App\Http\Controllers\Auth\AuthController::class,'info'])->name('admin.auth.info');
    $route->any('/load_menu', [App\Http\Controllers\Admin\MenusController::class,'loadMenu']);

    $route->get('/notices', 'NoticesController@index')->name('admin.notices.index');
    $route->get('/notices/{id}', 'NoticesController@show')->name('admin.notices.info');
    $route->post('/notices',  'NoticesController@store')->name('admin.notices.store');
    $route->put('/notices/{id}',  'NoticesController@update')->name('admin.notices.update');
    $route->delete('/notices/{id}', 'NoticesController@destroy')->name('admin.notices.destroy');

    $route->get('/article_menus', [App\Http\Controllers\Admin\ArticleMenusController::class,'index']);
    $route->get('/article_menus/{id}', [App\Http\Controllers\Admin\ArticleMenusController::class,'show']);
    $route->post('/article_menus', [App\Http\Controllers\Admin\ArticleMenusController::class,'store']);
    $route->put('/article_menus/{id}', [App\Http\Controllers\Admin\ArticleMenusController::class,'update']);
    $route->delete('/article_menus/{id}', [App\Http\Controllers\Admin\ArticleMenusController::class,'destroy']);

    $route->resource('articles', 'ArticlesController');
    $route->resource('goods_classes', 'GoodsClassesController');
    $route->post('uploads', 'UploadsController@upload')->name('admin.uploads');
    $route->resource('goods_brands', 'GoodsBrandsController');

    $route->get('configs', 'ConfigsController@index')->name('admin.configs');
    $route->put('configs/update', 'ConfigsController@edit')->name('admin.configs.update');

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

});

Route::prefix('Seller')->middleware('auth:users')->namespace('Seller')->group(function ($route) {
    $route->any('/auth/info', [App\Http\Controllers\Auth\AuthController::class,'info'])->name('admin.auth.info');
    $route->get('/load_menu', [App\Http\Controllers\Seller\MenusController::class,'loadMenu']);
    $route->resource('goods_attrs', 'GoodsAttrsController');

    $route->any('/auth/edit', 'AuthController@edit')->name('seller.auth.edit');
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


//    Route::resource('seckills', App\Http\Controllers\Seller\SeckillsController::class);
//    Route::resource('collectives', App\Http\Controllers\Seller\CollectivesController::class);
//    Route::resource('full_reductions', App\Http\Controllers\Seller\FullReductionsController::class);


});