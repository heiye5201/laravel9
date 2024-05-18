<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/18 09:03
 * description:
 */
namespace App\Http\Queries;

use App\Models\OrderComment;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class OrderCommentQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct(OrderComment::query());
        $this->defaultSort('-ID')
            ->allowedFilters([
                AllowedFilter::scope('name'),
                AllowedFilter::scope('code'),
                AllowedFilter::scope('content'),
            ])
            ->allowedSorts([
                AllowedSort::field('date', 'created_at'),
            ]);
    }
}
