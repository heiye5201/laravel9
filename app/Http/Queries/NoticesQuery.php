<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/6 22:13
 * description:
 */
namespace App\Http\Queries;

use App\Models\Notice;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class NoticesQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct(Notice::query());
        $this->defaultSort('-ID')
            ->allowedFilters([
                AllowedFilter::scope('name'),
                AllowedFilter::scope('content'),
                AllowedFilter::scope('is_type'),
                AllowedFilter::scope('is_send'),
            ])
            ->allowedSorts([
                AllowedSort::field('date', 'created_at'),
            ]);
    }
}
