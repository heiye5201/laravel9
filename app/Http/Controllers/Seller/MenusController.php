<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/4 00:46
 * description:
 */

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Services\UserMenuService;
use Illuminate\Http\Request;

class MenusController extends Controller
{
    public function loadMenu(Request $request)
    {
        try {
            $tree = app(UserMenuService::class)->loadMenu($request->all());
        } catch (\Exception $e) {
            return $this->error(__('tip.failed'));
        }
        return $this->success($tree);
    }
}