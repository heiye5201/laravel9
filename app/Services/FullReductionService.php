<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/16 22:08
 * description:
 */
namespace App\Services;

use App\Models\FullReduction;

class FullReductionService extends BaseService
{
    public function fullReductionInfoByStoreId($storeId, $total_price)
    {
        $info = FullReduction::query()->where('store_id', $storeId)
            ->where('start_time', '<', now())->where('end_time', '>', now())
            ->where('use_money', '<=', $total_price)->orderBy('use_money', 'asc')->first();
        if (!$info) {
            return $this->formatError('not found');
        }
        return $this->format($info);
    }
}