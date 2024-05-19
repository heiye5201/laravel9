<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/13 14:12
 * description:
 */
namespace App\Http\Queries;

use App\Models\User;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class UserQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct(User::query());
        $this->defaultSort('-ID')
            ->allowedFilters([
                'nickname','username','email',
            ])
            ->allowedSorts([
                AllowedSort::field('date', 'created_at'),
            ]);
    }
}