<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/16 22:06
 * description:
 */
namespace App\Services;

use App\Models\Seckill;

class SeckillService extends BaseService
{
    public function seckillInfoByGoodsId($goodsId = 0)
    {
        $info = Seckill::query()->select('discount', 'start_time', 'end_time')
            ->where('goods_id', $goodsId)->where('start_time', '<=', now())
            ->where('end_time', '>=', now())->first();
        if (!$info) {
            return $this->formatError('not found');
        }
        return $this->format($info);
    }
}