<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/19 18:48
 * description:
 */
namespace App\Http\Queries;

use App\Models\Express;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class ExpressQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct(Express::query());
        $this->defaultSort('-ID')
            ->allowedFilters([
                'name',
            ])
            ->allowedSorts([
                AllowedSort::field('date', 'created_at'),
            ]);
    }
}

