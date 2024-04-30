

# 构建镜像
docker-compose up -d mysql nginx redis

# 创建表
php artisan make:migration create_configs_table --create="configs"


# 添加字段
php artisan make:migration add_sales_to_discount_codes_table --table=discount_codes

php artisan make:controller PhotoController --resource


# 学习存储仓
源码地址：
https://github.com/andersao/l5-repository
安装存储仓扩展
``` shell
composer require prettus/l5-repository
```

php artisan make:repository "Admins"

php artisan make:bindings Admins


php artisan make:controller  Auth/AuthController


导出镜像 命令
``` shell
docker save -o laradock-mysql.tar laradock-mysql
docker save -o laradock-php-fpm-8.tar laradock-php-fpm-8
docker save -o laradock-nginx.tar laradock-nginx
docker save -o laradock-php-fpm.tar laradock-php-fpm
docker save -o laradock-workspace.tar laradock-workspace
docker save -o laradock-redis.tar laradock-redis
```

把这几个images拷贝到window系统上
在PowerShell 中执行以下命令，构建镜像：
``` shell
docker load -i C:\Users\YourUsername\my_macos_image.tar
```

php artisan migrate



{
"grant_type": "password",
"client_id": "9bee8802-d237-4924-9bd9-bfdc92124294",
"client_secret": "$2y$10$tiHsgQhM0QLtA8RpEhkmH.Tk1LLW5CY9k3DotRJuicf62DLIz4ly2",
"username": "admin",
"password": "123456",
"scope": ""
}
