<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/6 22:13
 * description:
 */
namespace App\Http\Queries;

use App\Models\Notice;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class NoticesQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct(Notice::query());
        $this->defaultSort('-ID')
            ->allowedFilters([
                'name',
                'content',
                'tag',
            ])
            ->allowedSorts([
                AllowedSort::field('date', 'created_at'),
            ]);
    }
}
