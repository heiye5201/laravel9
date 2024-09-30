<?php
/**
 * autor      : jiweijian
 * createTime : 2024/8/29 14:58
 * description:
 */
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class SwooleController extends Controller
{
    private static $counter = 0;

    public function increment()
    {
        self::$counter++;
        sleep(10);
        return response()->json(['counter' => self::$counter]);
    }
}