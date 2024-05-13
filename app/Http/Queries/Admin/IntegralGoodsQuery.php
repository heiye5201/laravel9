<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/13 15:08
 * description:
 */
namespace App\Http\Queries\Admin;

use App\Models\IntegralGoods;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class IntegralGoodsQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct(IntegralGoods::query());
        $this->defaultSort('-ID')
            ->allowedFilters([
                AllowedFilter::scope('goods_name'),
                AllowedFilter::scope('goods_subname'),
            ])
            ->allowedSorts([
                AllowedSort::field('date', 'created_at'),
            ]);
    }
}