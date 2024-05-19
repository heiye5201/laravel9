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
        $matchArray = explode('|', $value);
        $strMatch = $matchArray[1] ?? '';
        $strValue = $matchArray[0] ?? 0;
        switch ($strMatch) {
            case 'gt':
                return $query->where($property, '>', $strValue);
            case 'ngt':
                return $query->where($property, '<', $strValue);
        }
        return $query->where($property, $value);
    }
}
