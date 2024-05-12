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


});

Route::prefix('Seller')->middleware('auth:users')->group(function ($route) {
    $route->any('/auth/info', [App\Http\Controllers\Auth\AuthController::class,'info'])->name('admin.auth.info');
    $route->get('/load_menu', [App\Http\Controllers\Seller\MenusController::class,'loadMenu']);

});