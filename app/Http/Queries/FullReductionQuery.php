<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/19 16:36
 * description:
 */
namespace App\Http\Queries;

use App\Models\FullReduction;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class FullReductionQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct(FullReduction::query());
        $this->defaultSort('-ID')
            ->allowedFilters([
                'name',
            ])
            ->allowedSorts([
                AllowedSort::field('date', 'created_at'),
            ]);
    }
}