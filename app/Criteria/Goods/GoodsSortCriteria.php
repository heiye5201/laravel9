<?php
/**
 * autor      : jiweijian
 * createTime : 2024/11/28 15:57
 * description:
 */
namespace App\Criteria\Goods;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class GoodsSortCriteria implements CriteriaInterface
{
    public function __construct($filterData)
    {
        $this->request = $filterData;
    }

    const SORTBYCATEGORY = [
        'price-descending' => 'price_descending',
        'price-ascending' => 'price_ascending',
        'created-descending' => 'created_descending',
        'created-ascending' => 'created_ascending',
    ];

    public function apply($model, RepositoryInterface $repository)
    {
        $type = self::SORTBYCATEGORY[$this->request['sort']] ?? '';
        switch ($type) {
            case 'price_descending':
                $model = $model->orderByRaw('goods_price DESC');
                break;
            case 'price_ascending':
                $model = $model->orderByRaw('goods_price ASC');
                break;
            case 'created_ascending':
                $model = $model->orderByRaw('created_at ASC');
                break;
            case 'created_descending':
                $model = $model->orderByRaw('created_at DESC');
                break;
            default:
                $model = $model->orderByRaw('id DESC');
        }
        return $model;
    }
}