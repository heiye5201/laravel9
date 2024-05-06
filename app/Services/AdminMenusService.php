<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/3 20:28
 * description:
 */
namespace App\Services;

use App\Models\AdminMenu;

class AdminMenusService extends BaseService
{
    public function loadMenu($menu)
    {
        $isSuper = $this->getSuper('admins');
        $deep = $menu['deep'] ?? -1;
        if ($isSuper) {
            $data = AdminMenu::query()->select('id', 'name', 'ename', 'apis', 'view', 'pid', 'is_open', 'icon')
                ->orderBy('is_sort', 'asc')->get();
        } else {
            $roles = $this->getRoles(['menus']);
            $data = $roles['roles']['menus'] ?? [];
        }
        $treeType = $menu['type'] ?? 'getChildren';
        return app(ToolService::class)->$treeType($data, 0, 0, $deep);
    }
}