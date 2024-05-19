<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/13 18:25
 * description:
 */
namespace App\Http\Queries\Admin;

use App\Models\AdminMenu;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class AdminMenuQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct(AdminMenu::query());
        $this->defaultSort('-ID')
            ->allowedFilters([
                'ename', 'name',
            ])
            ->allowedSorts([
                AllowedSort::field('date', 'created_at'),
            ]);
    }
}