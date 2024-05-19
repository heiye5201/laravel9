<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/13 15:08
 * description:
 */
namespace App\Http\Queries\Admin;

use App\Models\IntegralGoodsClass;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class IntegralGoodsClassQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct(IntegralGoodsClass::query());
        $this->defaultSort('-ID')
            ->allowedFilters([
                'name',
            ])
            ->allowedSorts([
                AllowedSort::field('date', 'created_at'),
            ]);
    }
}