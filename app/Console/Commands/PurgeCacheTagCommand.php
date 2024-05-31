<?php
/**
 * autor      : jiweijian
 * createTime : 2024/5/31 09:30
 * description:
 */
namespace App\Console\Commands;

use Illuminate\Cache\RedisTaggedCache;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class PurgeCacheTagCommand extends Command
{
    // redis 大key 问题的处理方案
    // 使用定时任务来定时清理的方式

    // 详细见： https://github.com/laravel/framework/discussions/46175

    // laravel10+ 修复了该问题见：https://github.com/laravel/framework/pull/45690

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache:purge-tag';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Purge Expired Tags';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     */
    public function handle(): void
    {
        $prefix = config('database.redis.options.prefix');
        $key = $prefix. config('cache.prefix') .':*:'. RedisTaggedCache::REFERENCE_KEY_STANDARD;
        // function batch 用于分批清理，防止因过期元素过多导致unpack table失败
        $lua = <<<LUA
    local function batches(n, batchSize)
      local i = 0
      return function()
        local from = i * batchSize + 1
        i = i + 1
        if (from <= n) then
          local to = math.min(from + batchSize - 1, n)
          return from, to
        end
      end
    end

    local keys = redis.call('SMEMBERS', '%s')
    local expired = {}
    for i, key in ipairs(keys) do
    local ttl = redis.call('ttl', '%s'..key)
    if ttl == -2 then
        table.insert(expired, key)
    end
    end
    if #expired > 0 then
    for from, to in batches(#expired, 7000) do
        redis.call('SREM', '%s', unpack(expired, from, to))
    end
    end
    LUA;
        $redis = Redis::connection('cache');
        $start = microtime(true);
        $iterator = NULL;
        while($iterator !== 0) {
            // 游标查找
            [$iterator,$result] = $redis->scan($iterator, ['match' => $key]);
            $this->info('Scan cost: '.microtime(true) - $start);
            if(!$iterator) {
                $iterator = 0;
            }
            if(is_array($result)) {
                foreach($result as $tagKey) {
                    $this->info($tagKey);
                    $this->info($redis->eval(sprintf($lua, $tagKey, $prefix, $tagKey), 0));
                    $this->info('SREM cost: '.microtime(true) - $start);
                }
            }
        }
        $this->info('Redis Error: '.$redis->getLastError());
    }
}