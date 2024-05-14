<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/13 20:49
 * description:
 */
namespace App\Http\Queries;

use App\Models\GoodsAttr;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class GoodsAttrQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct(GoodsAttr::query());
        $this->defaultSort('-ID')
            ->allowedFilters([
                AllowedFilter::scope('name'),
            ])
            ->allowedSorts([
                AllowedSort::field('date', 'created_at'),
            ]);
    }
}
