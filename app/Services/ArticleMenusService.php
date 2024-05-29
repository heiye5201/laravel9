<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/12 20:25
 * description:
 */
namespace App\Services;

use App\Models\ArticleMenu;

class ArticleMenusService extends BaseService
{

    public function loadMenu($menu)
    {
        $this->isSuper = $this->getSuper('admins');
        $deep = $menu['deep'] ?? -1;
        $data = ArticleMenu::query()->select('id', 'name', 'pid')->orderBy('is_sort', 'asc')->get();
        $treeType = $menu['type'] ?? 'getChildren';
        return app(ToolService::class)->$treeType($data, 0, 0, $deep);
    }

}
