<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/3 13:59
 * description:
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AdminMenusService;
use Illuminate\Http\Request;

class MenusController extends Controller
{
    public function loadMenu(Request $request)
    {
        try {
            $tree = app(AdminMenusService::class)->loadMenu($request->all());
        } catch (\Exception $e) {
            return $this->error(__('tip.failed'));
        }
        return $this->success($tree);
    }
}