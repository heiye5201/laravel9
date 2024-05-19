<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/13 11:20
 * description:
 */
namespace App\Http\Queries;

use App\Filters\CustomFilter;
use App\Models\Cash;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class CashQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct(Cash::query());
        $this->defaultSort('-ID')
            ->allowedFilters([
                'name', 'bank_name', 'card_no', 'money', 'cash_status',
                AllowedFilter::custom('store_id', new CustomFilter()),
            ])
            ->allowedSorts([
                AllowedSort::field('date', 'created_at'),
            ]);
    }
}