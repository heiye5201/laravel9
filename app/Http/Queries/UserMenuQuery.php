<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/13 18:39
 * description:
 */

namespace App\Http\Queries;

use App\Models\UserMenu;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class UserMenuQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct(UserMenu::query());
        $this->defaultSort('-ID')
            ->allowedFilters([
                'name', 'content'
            ])
            ->allowedSorts([
                AllowedSort::field('date', 'created_at'),
            ]);
    }
}

