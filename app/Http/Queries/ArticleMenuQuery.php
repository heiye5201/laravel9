<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/6 22:13
 * description:
 */
namespace App\Http\Queries;

use App\Models\ArticleMenu;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class ArticleMenuQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct(ArticleMenu::query());
        $this->defaultSort('-ID')
            ->allowedFilters([
                'name',
                'pid',
            ])
            ->allowedSorts([
                AllowedSort::field('date', 'created_at'),
            ]);
    }
}
