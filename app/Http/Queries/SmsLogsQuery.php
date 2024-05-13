<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/13 11:20
 * description:
 */
namespace App\Http\Queries;

use App\Models\SmsLog;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class SmsLogsQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct(SmsLog::query());
        $this->defaultSort('-ID')
            ->allowedFilters([
                AllowedFilter::scope('name'),
                AllowedFilter::scope('phone'),
            ])
            ->allowedSorts([
                AllowedSort::field('date', 'created_at'),
            ]);
    }
}