<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/6 22:13
 * description:
 */
namespace App\Http\Queries;

use App\Filters\CustomFilter;
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
                'name',
                AllowedFilter::custom('pid', new CustomFilter()),
            ])
            ->allowedSorts([
                AllowedSort::field('date', 'created_at'),
                AllowedSort::field('click', 'click'),
            ]);
    }
}
