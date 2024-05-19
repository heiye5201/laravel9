<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/12 23:32
 * description:
 */
namespace App\Http\Queries;

use App\Models\GoodsClass;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class GoodsClassQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct(GoodsClass::query());
        $this->defaultSort('-ID')
            ->allowedFilters([
                'name'
            ])
            ->allowedSorts([
                AllowedSort::field('date', 'created_at'),
                AllowedSort::field('click', 'click'),
            ]);
    }
}