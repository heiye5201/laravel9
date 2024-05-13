<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/13 14:12
 * description:
 */
namespace App\Http\Queries\Admin;

use App\Models\Admins;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class AdminQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct(Admins::query());
        $this->defaultSort('-ID')
            ->allowedFilters([
                AllowedFilter::scope('username'),
                AllowedFilter::scope('nickname'),
            ])
            ->allowedSorts([
                AllowedSort::field('date', 'created_at'),
            ]);
    }
}