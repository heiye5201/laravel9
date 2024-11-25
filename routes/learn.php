<?php
/**
 * autor      : jiweijian
 * createTime : 2024/9/30 17:24
 * description:
 */

use Illuminate\Support\Facades\Route;

Route::prefix('Learn')->namespace('Learn')->name('learn.')->group(function ($route) {

    $route->get('/redis/getString', 'RedisController@getString')->name('getString');
    $route->get('/redis/getList', 'RedisController@getList')->name('getString');
    $route->get('/redis/getSet', 'RedisController@getList')->name('getSet');
    $route->get('/redis/getHash', 'RedisController@getHash')->name('getHash');
    $route->get('/redis/getSortedSet', 'RedisController@getSortedSet')->name('getSortedSet');
});