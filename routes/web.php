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

// 放到最下面，用来访问vue地址
Route::get('/{any}', [\App\Http\Controllers\SpaController::class,'index'])->where('any', '.*');

