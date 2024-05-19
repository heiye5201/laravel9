<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/19 13:52
 * description:
 */
namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class CustomFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        return $query->where('pid', $value);
    }
}
