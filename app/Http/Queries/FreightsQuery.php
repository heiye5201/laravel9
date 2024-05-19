<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/13 22:03
 * description:
 */
namespace App\Http\Queries;

use App\Models\Freight;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class FreightsQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct(Freight::query());
        $this->defaultSort('-ID')
            ->allowedFilters([
                'name',
            ])
            ->allowedSorts([
                AllowedSort::field('date', 'created_at'),
            ]);
    }
}
