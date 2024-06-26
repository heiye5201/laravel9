<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Queries\UserMenuQuery;
use App\Models\UserMenu;
use App\Services\ToolService;
use Illuminate\Http\Request;

class SellerMenusController extends Controller
{
    protected $auth = 'admins';
    protected $isSuper = false;

    // 获取前端菜单
    public function loadMenu(Request $request)
    {
        $treeType = $request->type ?? 'getChildren';
        $deep = $request->deep ?? -1;
        // 配置是否超级管理员
        $this->isSuper = $this->getSuper($this->auth);
        if ($this->isSuper) {
            $data = UserMenu::query()->select('id', 'name', 'ename', 'apis', 'view', 'pid', 'is_open', 'icon')->orderBy('is_sort', 'asc')->get();
        } else {
            $roles = $this->getRoles($this->auth, ['menus']);
            $data = $roles['menus'] ?? [];
        }
        try {
            $tree = app(ToolService::class)->$treeType($data, 0, 0, $deep);
        } catch (\Exception $e) {
            return $this->error(__('tip.failed'));
        }
        return $this->success($tree);
    }


    public function index(Request $request, UserMenuQuery $query)
    {
        $isChildren = boolval(request('isChildren') ?? false);
        if ($isChildren) {
            $belong_id = request('pid') ?? 0;
            $query = $query->where('pid', $belong_id)->with('hasChildren');
        }
        $data = $query->orderBy('id', 'desc')
            ->get();
        return $this->success($data);
    }


    public function show($id)
    {
        $data = UserMenu::query()->find($id);
        return $this->success($data);
    }
}
