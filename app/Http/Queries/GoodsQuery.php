<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/13 22:03
 * description:
 */
namespace App\Http\Queries;

use App\Models\Goods;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class GoodsQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct(Goods::query());
        $this->defaultSort('-ID')
            ->allowedFilters([
                'goods_name',
                'goods_status',
                'goods_verify'
            ])
            ->allowedSorts([
                AllowedSort::field('date', 'created_at'),
            ]);
    }
}
