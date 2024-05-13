<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/13 17:06
 * description:
 */
namespace App\Http\Queries\Admin;

use App\Models\AdminPermission;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class PermissionQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct(AdminPermission::query());
        $this->defaultSort('-ID')
            ->allowedFilters([
                AllowedFilter::scope('name'),
                AllowedFilter::scope('content'),
            ])
            ->allowedSorts([
                AllowedSort::field('date', 'created_at'),
            ]);
    }
}