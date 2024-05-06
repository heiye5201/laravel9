<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/4 01:04
 * description:
 */
namespace App\Services;

use App\Models\UserMenu;

class UserMenuService extends BaseService
{

    protected $auth = 'users';

    // 获取前端菜单
    public function loadMenu($data)
    {
        $treeType = $data['type'] ?? 'getChildren';
        $deep = $data['deep'] ?? -1;
        // 配置是否超级管理员
        $isSuper = $this->getSuper($this->auth);
        if ($isSuper) {
            $data = UserMenu::query()->select('id', 'name', 'ename', 'apis', 'view', 'pid', 'is_open', 'icon')
                ->orderBy('is_sort', 'asc')->get();
        } else {
            $roles = $this->getRoles($this->auth, ['menus']);
            $data = $roles['roles']['menus'] ?? [];
        }
        try {
            $menus = __('tip.menu');
            $data = collect($data)->map(function ($item) use ($menus) {
                $item['name'] =  $menus[$item['local_key']] ?? $item['name'];
                return $item;
            });
            return app(ToolService::class)->$treeType($data, 0, 0, $deep);
        } catch (\Exception $e) {
            return $this->error(__('tip.failed'));
        }
    }
}