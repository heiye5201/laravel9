<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/17 23:27
 * description:
 */

namespace App\Http\Queries;

use App\Models\Store;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class StoreQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct(Store::query());
        $this->defaultSort('-ID')
            ->allowedFilters([
                'store_name', 'store_description', 'store_mobile',
            ])
            ->allowedSorts([
                AllowedSort::field('date', 'created_at'),
            ]);
    }
}
