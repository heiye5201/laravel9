<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/18 11:11
 * description:
 */
namespace App\Http\Queries;

use App\Models\OrderSettlement;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class OrderSettlementQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct(OrderSettlement::query());
        $this->defaultSort('-ID')
            ->allowedFilters([
                'status',
            ])
            ->allowedSorts([
                AllowedSort::field('date', 'created_at'),
            ]);
    }
}