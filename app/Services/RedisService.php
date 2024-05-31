<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/31 15:14
 * description:
 */
namespace App\Services;

use Illuminate\Support\Facades\Cache;

class RedisService extends BaseService
{
    public function setTag()
    {
        $tag = 'my-tag';
        $key1 = 'my-key1';
        $val1 = 'my-val1';
        $key2 = 'my-key2';
        $val2 = 'my-val2';
        Cache::tags($tag)->put($key1, $val1, 3600);
        Cache::tags($tag)->put($key2, $val2, 3600);
        return Cache::tags($tag)->get($key1);
    }

    // ollama
    public function deleteTag()
    {
        $tagName = 'my-tag';
        return Cache::tags($tagName)->flush();
    }
}