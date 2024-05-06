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

Route::prefix('Admin')->middleware('auth:admins')->group(function ($route) {
    $route->any('/auth/info', [App\Http\Controllers\Auth\AuthController::class,'info'])->name('admin.auth.info');
    $route->any('/load_menu', [App\Http\Controllers\Admin\MenusController::class,'loadMenu']);
});

Route::prefix('Seller')->middleware('auth:users')->group(function ($route) {
    $route->any('/auth/info', [App\Http\Controllers\Auth\AuthController::class,'info'])->name('admin.auth.info');
    $route->get('/load_menu', [App\Http\Controllers\Seller\MenusController::class,'loadMenu']);

});