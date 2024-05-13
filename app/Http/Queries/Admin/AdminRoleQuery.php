<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/13 14:12
 * description:
 */
namespace App\Http\Queries\Admin;

use App\Models\AdminRole;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class AdminRoleQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct(AdminRole::query());
        $this->defaultSort('-ID')
            ->allowedFilters([
                AllowedFilter::scope('name'),
            ])
            ->allowedSorts([
                AllowedSort::field('date', 'created_at'),
            ]);
    }
}