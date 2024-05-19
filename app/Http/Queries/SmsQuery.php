<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/13 11:20
 * description:
 */
namespace App\Http\Queries;

use App\Models\Sms;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class SmsQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct(Sms::query());
        $this->defaultSort('-ID')
            ->allowedFilters([
                'name', 'code', 'content',
            ])
            ->allowedSorts([
                AllowedSort::field('date', 'created_at'),
            ]);
    }
}