<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


//Route::get('/checkVersion', [\App\Http\Controllers\Controller::class, 'checkVersion']);

Route::prefix('Admin')->middleware('auth:admins')->group(function ($route) {

//    $route->get('load_permission', [App\Http\Controllers\Admin\PermissionsController::class,'loadPermission']);
//    $route->any('/auth/info', [App\Http\Controllers\Auth\AuthController::class,'info'])->name('admin.auth.info');
//    $route->any('/auth/edit', [App\Http\Controllers\Auth\AuthController::class,'edit'])->name('admin.auth.edit');
//    $route->resource('admins', App\Http\Controllers\Admin\AdminsController::class);
//    $route->resource('users', App\Http\Controllers\Admin\UsersController::class);
//    $route->post('users/money/handle', [App\Http\Controllers\Admin\UsersController::class,'money']);

});

// Route::get('/', function () {
//     return view('welcome');
// });


// 放到最下面，用来访问vue地址
Route::get('/{any}', [\App\Http\Controllers\SpaController::class,'index'])->where('any', '.*');


