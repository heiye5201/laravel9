<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/18 09:00
 * description:
 */
namespace App\Http\Queries;

use App\Models\Address;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class AddressQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct(Address::query());
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
