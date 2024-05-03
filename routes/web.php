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

use Laravel\Passport\Http\Controllers\AccessTokenController;
use Laravel\Passport\Http\Controllers\AuthorizationController;
use Laravel\Passport\Http\Controllers\ApproveAuthorizationController;
use Laravel\Passport\Http\Controllers\DenyAuthorizationController;
use Laravel\Passport\Http\Controllers\TransientTokenController;

//Route::post('/oauth/token', [AccessTokenController::class, 'issueToken']);
//Route::get('/oauth/authorize', [AuthorizationController::class, 'authorize']);
//Route::post('/oauth/authorize', [ApproveAuthorizationController::class, 'approve']);
//Route::delete('/oauth/authorize', [DenyAuthorizationController::class, 'deny']);
//Route::get('/oauth/scopes', [AuthorizationController::class, 'scopes']);
//Route::get('/oauth/tokens', [TransientTokenController::class, 'forUser']);
//Route::delete('/oauth/tokens/{token_id}', [TransientTokenController::class, 'destroy']);


//Route::prefix('Admin')->middleware('auth:admins')->group(function ($route) {

//    $route->get('load_permission', [App\Http\Controllers\Admin\PermissionsController::class,'loadPermission']);
//    $route->any('/auth/info', [App\Http\Controllers\Auth\AuthController::class,'info'])->name('admin.auth.info');
//    $route->any('/auth/edit', [App\Http\Controllers\Auth\AuthController::class,'edit'])->name('admin.auth.edit');
//    $route->resource('admins', App\Http\Controllers\Admin\AdminsController::class);
//    $route->resource('users', App\Http\Controllers\Admin\UsersController::class);
//    $route->post('users/money/handle', [App\Http\Controllers\Admin\UsersController::class,'money']);

//});

// Route::get('/', function () {
//     return view('welcome');
// });

//Route::post('/oauth/token', [\Laravel\Passport\Http\Controllers\AccessTokenController::class, 'issueToken']);
//Route::get('/oauth/authorize', [\Laravel\Passport\Http\Controllers\AuthorizationController::class, 'authorize']);
//Route::post('/oauth/authorize', [\Laravel\Passport\Http\Controllers\ApproveAuthorizationController::class, 'approve']);
//Route::delete('/oauth/authorize', [\Laravel\Passport\Http\Controllers\DenyAuthorizationController::class, 'deny']);
//Route::get('/oauth/scopes', [\Laravel\Passport\Http\Controllers\AuthorizationController::class, 'scopes']);
//Route::get('/oauth/tokens', [\Laravel\Passport\Http\Controllers\TransientTokenController::class, 'forUser']);
//Route::delete('/oauth/tokens/{token_id}', [\Laravel\Passport\Http\Controllers\TransientTokenController::class, 'destroy']);

//Route::post('/oauth/token', function () {
//    return [];
//});

// 放到最下面，用来访问vue地址
Route::get('/{any}', [\App\Http\Controllers\SpaController::class,'index'])->where('any', '.*');

