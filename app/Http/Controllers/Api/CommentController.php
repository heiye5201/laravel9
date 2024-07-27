<?php
/**
 * autor      : jiweijian
 * createTime : 2024/7/27 12:38
 * description:
 */
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class CommentController extends Controller
{

    public function getListRows()
    {
        $data = [
            'list' => [],
            'total' => 0,
        ];
        return $this->app_success($data);
    }
}