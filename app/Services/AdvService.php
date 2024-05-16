<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/16 21:45
 * description:
 */

namespace App\Services;

use App\Models\Adv;
use App\Models\AdvSpace;

class AdvService extends BaseService
{
    // 根据广告位的名称获取广告图片
    public function adv($name = null)
    {
        if (empty($name)) return $this->formatError('space name find error.');
        $space = AdvSpace::query()->where('name', $name)->first();
        $list = Adv::query()->where('pid', $space['id'])->where('adv_start', '<', date('Y-m-d H:i:s'))->where('adv_end', '>', date('Y-m-d H:i:s'))->get();
        return $this->format($list);
    }


    /**
     * 根据广告位类型获取广告图片
     * @param null $local_type
     * @return array
     */
    public function advNew($local_type = null)
    {
        if (empty($local_type)) return $this->formatError('space name find error.');
        $space = AdvSpace::query()->where('local_type', $local_type)->first();
        $data = [];
        if ($space) {
            $list = Adv::query()->where('pid', $space['id'])
                ->where('adv_start', '<', date('Y-m-d H:i:s'))->where('adv_end', '>', date('Y-m-d H:i:s'))->get();
            foreach ($list as $val) {
                $data[] = ['image' => $val['image']];
            }
        }
        return $data;
    }


    /**
     * 根据广告位类型获取广告图片
     * @param null $local_type
     * @return array
     */
    public function advApp($local_type = null)
    {
        if (empty($local_type)) return $this->formatError('space name find error.');
        $space = AdvSpace::query()->where('local_type', $local_type)->first();
        $list = [];
        if ($space) {
            $list = Adv::query()->where('pid', $space['id'])
                ->where('adv_start', '<', date('Y-m-d H:i:s'))->where('adv_end', '>', date('Y-m-d H:i:s'))->get();
        }
        return $list;
    }
}