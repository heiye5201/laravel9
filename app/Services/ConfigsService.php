<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/13 13:54
 * description:
 */

namespace App\Services;

use App\Models\Configs;
use App\Traits\ResourceTrait;

class ConfigsService
{
    use ResourceTrait;

    public function getFormatConfig($name = null, $manyName = null, $many = false)
    {
        $nameType = is_array($name);
        if ($nameType) {
            $info = Configs::query()->whereIn('name', $name)->get();
        } else {
            $info = Configs::query()->where('name', $name)->first();
        }
        if (!$info) {
            throw new \Exception(__('tip.configThr'));
        }
        $data = [];
        if (!$many) {
            if ($nameType) {
                foreach ($info as $v) {
                    if ($v['is_type'] == 0) {
                        $data[$v['name']] = $v['content'];
                    }
                    if ($v['is_type'] == 1) {
                        $data[$v['name']] = json_decode($v['content'], true);
                    }
                }
            } else {
                if ($info['is_type'] == 0) {
                    $data = $info['content'];
                }
                if ($info['is_type'] == 1) {
                    $data = json_decode($info['content'], true);
                }
            }
        } else {
            $jsonData = json_decode($info['content'], true);
            $data = $jsonData[$manyName] ?? [];
        }
        return $data;
    }

    public function editConfig($resp)
    {
        $manyName = $resp['many_name'] ?? null;
        $many = $resp['many'] ?? false;
        if ($many && !empty($many)) {
            unset($resp['many_name']);
            unset($resp['many']);
            try {
                foreach ($resp as $k => $v) {
                    if (is_array($v)) {
                        foreach ($v as $key => $vo) {
                            if ($vo == 'true') {
                                $v[$key] = true;
                            }
                            if ($vo == 'false') {
                                $v[$key] = false;
                            }
                            if ($vo == 'null') {
                                $v[$key] = '';
                            }
                        }
                    }
                    $info = Configs::query()->where('name', $k)->first();
                    $jsonData = json_decode($info['content'], true);
                    $jsonData[$manyName] = $v;
                    Configs::query()->where('name', $k)->update(['content' => json_encode($jsonData)]);
                }
            } catch (\Exception $e) {
                return $this->formatError($e->getMessage());
            }
        } else {
            try {
                foreach ($resp as $k => $v) {
                    if (is_array($v)) {
                        foreach ($v as $key => $vo) {
                            if ($vo == 'true') {
                                $v[$key] = true;
                            }
                            if ($vo == 'false') {
                                $v[$key] = false;
                            }
                            if ($vo == 'null') {
                                $v[$key] = '';
                            }
                        }
                    }
                    Configs::query()->where('name', $k)->update(['content' => is_array($v) ? json_encode($v) : $v]);
                }
            } catch (\Exception $e) {
                return $this->formatError($e->getMessage());
            }
        }
        return $this->format($resp);
    }

    // 获取键值config
    public function getKeyVal($filter = [])
    {
        $data = [];
        $info = Configs::query()->whereIn('name', $filter)->get();
        if (!$info) {
            return $this->format([]);
        }
        foreach ($info as $v) {
            $data[$v['name']] = $v['content'];
        }
        return $this->format($data);
    }
}
