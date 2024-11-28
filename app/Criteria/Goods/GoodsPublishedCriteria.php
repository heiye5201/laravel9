<?php
/**
 * autor      : jiweijian
 * createTime : 2024/11/28 16:05
 * description:
 */
namespace App\Criteria\Goods;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class GoodsPublishedCriteria implements CriteriaInterface
{

    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where('goods_status', 1)->where('goods_verify', 1);
    }
}