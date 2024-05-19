<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/13 11:20
 * description:
 */
namespace App\Http\Queries;

use App\Filters\CustomFilter;
use App\Models\MoneyLog;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class MoneyLogQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct(MoneyLog::query());
        $this->defaultSort('-ID')
            ->allowedFilters([
                'name', 'money', 'is_type',
                AllowedFilter::custom('is_belong', new CustomFilter()),
            ])
            ->allowedSorts([
                AllowedSort::field('date', 'created_at'),
            ]);
    }
}