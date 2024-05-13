<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/13 14:12
 * description:
 */
namespace App\Http\Queries;

use App\Models\Area;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class AreaQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct(Area::query());
        $this->defaultSort('-ID')
            ->allowedFilters([
                AllowedFilter::scope('name'),
                AllowedFilter::scope('pid'),
            ])
            ->allowedSorts([
                AllowedSort::field('date', 'created_at'),
            ]);
    }
}