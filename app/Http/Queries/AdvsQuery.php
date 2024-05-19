<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/13 11:20
 * description:
 */
namespace App\Http\Queries;

use App\Models\Adv;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class AdvsQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct(Adv::query());
        $this->defaultSort('-ID')
            ->allowedFilters([
                'pid', 'name', 'adv_start', 'adv_end',
            ])
            ->allowedSorts([
                AllowedSort::field('date', 'created_at'),
            ]);
    }
}