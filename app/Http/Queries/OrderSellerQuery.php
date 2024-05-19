<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/18 11:02
 * description:
 */
namespace App\Http\Queries;

use App\Models\OrderSeller;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class OrderSellerQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct(OrderSeller::query());
        $this->defaultSort('-ID')
            ->allowedFilters([
                'order_status','order_no', 'order_name', 'refund_status',
            ])
            ->allowedSorts([
                AllowedSort::field('date', 'created_at'),
            ]);
    }
}