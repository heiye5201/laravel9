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
