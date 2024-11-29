<?php
/**
 * autor      : jiweijian
 * createTime : 2024/11/28 17:46
 * description:
 */
namespace App\Models\Traits;

use App\Models\Traits\Accessors\GoodsAccessor;
use App\Models\Traits\Mutators\GoodsMutator;

trait GoodsEntity
{
    use GoodsAccessor, GoodsMutator;
}
