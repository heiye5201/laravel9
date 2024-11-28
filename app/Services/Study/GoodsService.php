<?php
/**
 * autor      : jiweijian
 * createTime : 2024/11/28 15:51
 * description:
 */
namespace App\Services\Study;

use App\Criteria\Goods\GoodsPublishedCriteria;
use App\Criteria\Goods\GoodsSortCriteria;
use App\Repositories\Goods\Interfaces\GoodsRepository;

class GoodsService
{
    public $goodsRepository;

    public function __construct(GoodsRepository $goodsRepository)
    {
        $this->goodsRepository = $goodsRepository;
    }


    public function storeproductFilterAndSort($filterData)
    {
        $this->goodsRepository->pushCriteria(new GoodsSortCriteria($filterData));
        $this->goodsRepository->pushCriteria(new GoodsPublishedCriteria($filterData));
        return $this->goodsRepository;
    }


    public function goodsPaginator($filterData)
    {
        return $this->storeproductFilterAndSort($filterData)->goodsPaginate($filterData);
    }
}