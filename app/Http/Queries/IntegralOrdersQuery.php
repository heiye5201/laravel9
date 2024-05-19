<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/18 10:25
 * description:
 */

namespace App\Http\Queries;

use App\Models\IntegralOrder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class IntegralOrdersQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct(IntegralOrder::query());
        $this->defaultSort('-ID')
            ->allowedFilters([
                'order_no', 'order_name', 'order_status',
            ])
            ->allowedSorts([
                AllowedSort::field('date', 'created_at'),
            ]);
    }
}

