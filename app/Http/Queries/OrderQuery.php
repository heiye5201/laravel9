<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/18 22:16
 * description:
 */
namespace App\Http\Queries;

use App\Models\Order;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class OrderQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct(Order::query());
        $this->defaultSort('-ID')
            ->allowedFilters([
                'order_no', 'order_name','order_status','refund_status'
            ])
            ->allowedSorts([
                AllowedSort::field('date', 'created_at'),
            ]);
    }
}
