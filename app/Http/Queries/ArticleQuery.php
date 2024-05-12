<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/6 22:13
 * description:
 */
namespace App\Http\Queries;

use App\Models\Article;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class ArticleQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct(Article::query());
        $this->defaultSort('-ID')
            ->allowedFilters([
                AllowedFilter::scope('name'),
                AllowedFilter::scope('pid'),
                AllowedFilter::scope('type'),
                AllowedFilter::scope('content'),
            ])
            ->allowedSorts([
                AllowedSort::field('date', 'created_at'),
                AllowedSort::field('click', 'click'),
            ]);
    }
}
