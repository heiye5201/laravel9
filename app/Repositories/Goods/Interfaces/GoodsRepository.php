<?php

namespace App\Repositories\Goods\Interfaces;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface GoodsRepositoryRepository.
 *
 * @package namespace App\Repositories\Goods;
 */
interface GoodsRepository extends RepositoryInterface
{
    /**
     *
     * 获取商品列表信息
     *
     * @param $request
     * @return mixed
     */
    public function goodsPaginate($request);


    public function createGoods(array $data);

    public function updateGoods(int $id ,array $data);
}
