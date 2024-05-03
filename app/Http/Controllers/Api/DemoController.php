<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/2 21:14
 * description:
 */
namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Hash;

class DemoController
{
    public function index()
    {
        return ['data'=> Hash::make('123456')];
    }
}