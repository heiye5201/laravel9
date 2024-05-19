<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/13 11:20
 * description:
 */
namespace App\Http\Queries;

use App\Models\AdvSpace;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class AdvSpacesQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct(AdvSpace::query());
        $this->defaultSort('-ID')
            ->allowedFilters([
                'name',
            ])
            ->allowedSorts([
                AllowedSort::field('date', 'created_at'),
            ]);
    }
}