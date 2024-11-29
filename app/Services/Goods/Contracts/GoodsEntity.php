<?php
/**
 * autor      : jiweijian
 * createTime : 2024/11/28 17:29
 * description:
 */
namespace App\Services\Goods\Contracts;

use App\Services\Goods\Contracts\Accessors\GoodsAccessor;
use App\Services\Goods\Contracts\Mutators\GoodsMutator;

interface GoodsEntity extends GoodsAccessor, GoodsMutator
{

}