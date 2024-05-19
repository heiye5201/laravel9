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
                'receive_name', 'receive_tel', 'area_info', 'address',
            ])
            ->allowedSorts([
                AllowedSort::field('date', 'created_at'),
            ]);
    }
}
