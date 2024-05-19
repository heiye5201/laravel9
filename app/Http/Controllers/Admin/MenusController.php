<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/3 13:59
 * description:
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Queries\Admin\AdminMenuQuery;
use App\Models\AdminMenu;
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

    public function index(Request $request, AdminMenuQuery $query)
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
        $data = AdminMenu::query()->find($id);
        return $this->success($data);
    }
}