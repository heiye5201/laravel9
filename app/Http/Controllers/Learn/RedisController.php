<?php
/**
 * autor      : jiweijian
 * createTime : 2024/9/30 17:05
 * description:
 */
namespace App\Http\Controllers\Learn;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;

class RedisController extends Controller
{

    // https://zhuanlan.zhihu.com/p/663851226

    /**
     * String 用于简单的键值存储
     * String (字符串)
     * @return mixed
     */
    public function getString()
    {
        // 设置一个字符串键
        Redis::set('name', 'John Doe');
        // 获取字符串键的值
        $name = Redis::get('name');
        return $this->app_success(['name'=>$name]);
    }


    /**
     * List 是双向链表，支持先进先出的操作
     * List (列表)
     * @return mixed
     */
    public function getList()
    {
        // 从左侧推入值
        Redis::lpush('names', 'Alice');
        Redis::lpush('names', 'Bob');
        // 从右侧推入值
        Redis::rpush('names', 'Charlie');
        // 获取整个列表
        $names = Redis::lrange('names', 0, -1);
        return $this->app_success(['names'=>$names]);
    }


    /**
     * Set 是无序集合，元素唯一
     * Set (集合)
     * @return mixed
     */
    public function getSet()
    {
        // 添加元素到集合
        Redis::sadd('colors', 'red');
        Redis::sadd('colors', 'blue');
        Redis::sadd('colors', 'green');
        // 获取集合中的所有元素
        $colors = Redis::smembers('colors'); // 输出: ['red', 'blue', 'green']
        // 判断一个元素是否在集合中
        $isMember = Redis::sismember('colors', 'red');  // 输出: bool(true)
        return $this->app_success(['colors'=>$colors, 'isMember'=>$isMember]);
    }


    /**
     * Hash 是键值对的集合，适合存储对象
     * Hash (哈希)
     * @return mixed
     */
    public function getHash()
    {
        // 设置哈希
        Redis::hmset('user:1', ['name' => 'John Doe', 'email' => 'john@example.com']);
        // 获取整个哈希
        $user = Redis::hgetall('user:1');  // 输出: ['name' => 'John Doe', 'email' => 'john@example.com']
        // 获取单个字段的值
        $name = Redis::hget('user:1', 'name');  // 输出: John Doe
        return $this->app_success(['user'=>$user, 'name'=>$name]);
    }


    /**
     * Sorted Set 是带有排序的集合，适合排行榜等场景。
     * Sorted Set (有序集合)
     * @return mixed
     */
    public function getSortedSet()
    {
        // 添加元素到有序集合并设置分数
        Redis::zadd('scores', 100, 'Player1');
        Redis::zadd('scores', 200, 'Player2');
        Redis::zadd('scores', 150, 'Player3');
        // 获取有序集合中的所有元素
        $scores = Redis::zrange('scores', 0, -1, ['withscores' => true]); // 输出: ['Player1' => 100, 'Player3' => 150, 'Player2' => 200]
        // 获取排名前2名的玩家
        $topPlayers = Redis::zrevrange('scores', 0, 1, ['withscores' => true]); // 输出: ['Player2' => 200, 'Player3' => 150]
        return $this->app_success(['scores'=>$scores, 'topPlayers'=>$topPlayers]);
    }
}