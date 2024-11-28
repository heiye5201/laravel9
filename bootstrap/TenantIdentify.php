<?php


/**
 * 租户识别
 *
 * 这段代码是初始化代码，因此不能引用系统之外的包
 * 才能保证高效率执行。
 */
class TenantIdentity
{
    const READ_MODE           = 'read_mode';           //只读
    const READ_AND_WRITE_MODE = 'read_and_write_mode'; //可读写

    const TENANT_HOST_KEY    = 'tenant_host';
    const TENANT_SECRETS_KEY = 'tenant_secrets';

    /**
     * 获取随机读库配置
     * @return int[]
     */
    private function getConfig($mode)
    {
        if ($mode == self::READ_AND_WRITE_MODE) {
            //可读写，主库
            $host = getenv('REDIS_SHARED_HOST_MASTER') ?: getenv('REDIS_SHARED_HOST');
            $port = getenv('REDIS_SHARED_PORT_MASTER') ?: getenv('REDIS_SHARED_PORT');
            $password = getenv('REDIS_SHARED_PASSWORD_MASTER') ?: getenv('REDIS_SHARED_PASSWORD');
            $database = getenv('REDIS_SHARED_CACHE_DB_MASTER') ?: getenv('REDIS_SHARED_CACHE_DB');
        } else {
            //只读，从库
            $host = getenv('REDIS_SHARED_HOST_FOR_READ') ?: getenv('REDIS_SHARED_HOST');
            $port = getenv('REDIS_SHARED_PORT_FOR_READ') ?: getenv('REDIS_SHARED_PORT');
            $password = getenv('REDIS_SHARED_PASSWORD_FOR_READ') ?: getenv('REDIS_SHARED_PASSWORD');
            $database = getenv('REDIS_SHARED_CACHE_DB_FOR_READ') ?: getenv('REDIS_SHARED_CACHE_DB');
        }
        return [
            'host'     => $host ?: '127.0.0.1',
            'port'     => $port ?: 6379,
            'password' => $password,
            'db'       => $database ?: 3,
        ];
    }

    public function getRedisClient($mode = self::READ_AND_WRITE_MODE)
    {
        $config = $this->getConfig($mode);
        $host = $config['host'];
        $port = $config['port'];
        $password = $config['password'];
        $prefix = 'shared_cache:';
        $database = $config['db'];

        $client = new Redis();
        // 使用长链接，防止链接数爆掉
        if (!$client->pconnect($host, $port)) {
            // TODO:写入器读不成功，就读只读器
        }

        if (!empty($password)) {
            $client->auth($password);
        }

        if (!empty($database)) {
            $client->select((int)$database);
        }

        if (!empty($prefix)) {
            $client->setOption(Redis::OPT_PREFIX, $prefix);
        }
        return $client;
    }

    /**
     * 读取缓存数据
     */
    public function getCacheData(string $key)
    {
        $client = $this->getRedisClient(self::READ_MODE);
        return $client->get($key);
    }

    /**
     * 解密配置数据
     * 注意！SaaS控制中心与wshop需要保持完全一样的加密 KEY，否则会导致无法加解密！不要变动这个 APP_KEY
     * 这是一个流程上脆弱的点
     *
     * @param string $payload 加密的配置数据
     * @return false|string
     */
    public function decryptData($payload)
    {
        $appKey = getenv('APP_KEY');
        $appKey = base64_decode(str_replace('base64:', '', $appKey));
        $cipher = 'AES-256-CBC';
        $payload = json_decode(base64_decode($payload), true);

        $iv = base64_decode($payload['iv']);
        return \openssl_decrypt(
            $payload['value'], $cipher, $appKey, 0, $iv
        );
    }

    public function identifyByHost($host)
    {
        // 替换掉域名里的 .cn. 的3级域名，当前我们会配置 abc.cn.wshopon.com 类似这样的域名来支持域名扩展，openresty 自己做了一层处理，这里我们与 openresty 的处理要保持一致
        $host = str_replace(".cn.", ".", $host);

        if (preg_match('/(.*)\.wshopon\.com/', $host, $matches) > 0
            || preg_match('/(.*)\.hotishop\.com/', $host, $matches) > 0
        ) {
            $this->identify($matches[1]);
        } else {
            $tenantName = $this->getCacheData(self::TENANT_HOST_KEY . ':' . $host);
            if (!$tenantName) {
                header("HTTP/1.1 404 Not Found");
                exit();
            }
            $this->identify(unserialize($tenantName));
        }
    }

    /**
     * 根据店铺名切换租户配置
     *
     * @param string $tenantName 租户名称
     */
    public function identify($tenantName)
    {
        // 从缓存中获取店铺配置
        $payload = $this->getCacheData(self::TENANT_SECRETS_KEY . ':' . $tenantName);
        if (!$payload) {
            header("HTTP/1.0 404 Not Found");
            exit();
        }
        $payload = unserialize($payload);
        $config = $this->decryptData($payload);
        $config = json_decode($config, true);

        // 设置环境变量
        if ($config && is_array($config)) {
            foreach ($config as $key => $value) {
                if (in_array($key, ['REDIS_SHARED_HOST', 'REDIS_SHARED_PASSWORD', 'REDIS_SHARED_PORT'])) {
                    continue;
                }
                putenv("{$key}={$value}");
                $_ENV[$key] = $value;
            }
            $cachePrefix = $tenantName . '_cache';
            putenv("CACHE_PREFIX={$cachePrefix}");
            $_ENV['CACHE_PREFIX'] = $cachePrefix;

            putenv("QUEUE_CONNECTION=shared");
            $_ENV['QUEUE_CONNECTION'] = 'shared';

            putenv("LOG_CHANNEL=tenant");
            $_ENV['LOG_CHANNEL'] = 'tenant';
        }
    }
}


$service = new TenantIdentity();
if (getenv('TENANT_MASTER_HTTP') && php_sapi_name() !== 'cli') {
    $host = $_SERVER['HTTP_HOST'];
    $service->identifyByHost($host);
}
