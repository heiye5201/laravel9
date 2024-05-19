<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/13 11:20
 * description:
 */
namespace App\Http\Queries;

use App\Models\AdvSpace;
use App\Models\Agreement;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class AgreementQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct(Agreement::query());
        $this->defaultSort('-ID')
            ->allowedFilters([
                'name', 'ename',
            ])
            ->allowedSorts([
                AllowedSort::field('date', 'created_at'),
            ]);
    }
}