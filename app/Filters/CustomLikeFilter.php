<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/19 09:36
 * description:
 */
namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class CustomLikeFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        // 如果传入的值以 |likeRight 结尾，则使用 likeRight 逻辑
        if (str_ends_with($value, '|likeRight')) {
            $name = str_replace('|likeRight', '', $value);
            $query->where($property, 'like', "$name%");
        } else {
            // 否则默认使用 like 逻辑
            $query->where($property, 'like', "%$value%");
        }
    }
}