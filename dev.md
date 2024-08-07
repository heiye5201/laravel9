

# 构建镜像
docker-compose up -d mysql nginx redis

构建php8版本出来
docker-compose build --no-cache php-fpm-8
docker-compose up -d php-fpm-8
docker-compose up -d workspace

docker-compose exec workspace php -v

注意php.ini如果没有开启 会出现大问题， 如果报错只会显示在php对应容器日志下， 而不是直接写到laravel.log下的
``` env
xdebug.mode=debug
```

# 创建表
php artisan make:migration create_configs_table --create="configs"
php artisan make:migration create_user_menus_table --create="user_menus"
php artisan make:migration create_discount_rule_filters_table --create="discount_rule_filters"

php artisan make:migration create_discount_rules_table --create="discount_rules"

php artisan migrate

# 添加字段
php artisan make:migration add_is_own_join_to_discount_rule_filters_table --table=discount_rule_filters

php artisan make:controller PhotoController --resource

php artisan make:migration add_free_amount_to_order_discount_record_table --table=order_discount_record

# 学习存储仓
源码地址：
https://github.com/andersao/l5-repository
安装存储仓扩展
``` shell
composer require prettus/l5-repository
```
admin_menus

php artisan make:repository "AdminMenu"

php artisan make:bindings AdminMenu


php artisan make:controller  Admin/CashesController


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




## Passport OAuth 认证
按照文档步骤按照，
由于 从 11.x 升级到 12.0 有些重大的改变
Passport 12.0 不再自动从其自己的迁移目录加载迁移。相反，您应该运行以下命令将 Passport 的迁移发布到您的应用程序：
```xshell
php artisan vendor:publish --tag=passport-migrations
```

## 密码授予类型
默认情况下禁用密码授予类型。您可以通过调用应用程序类的方法enablePasswordGrant中的方法来启用它：bootApp\Providers\AppServiceProvider
```php
public function boot(): void {
    Passport::enablePasswordGrant();
}
```
## 测试代码
``` xshell
curl --request POST --header 'accept: application/json' --header 'content-type: application/json' --data '{"username":"person@example.com","password":"ZCP7kT","grant_type":"password","client_id":2,"client_secret":"<secret>","scope":"*","device_uuid":"B11D89CD-2208-4893-DAEB-1545C3351858"}' 'http://jwj.test/oauth/token'
```

## 清理路由

```php
php artisan route:clear
php artisan route:cache
```

## 表单验证
php artisan make:request StorePostRequest

php artisan make:controller  Admin/DashboardController


## 生成模型并生成迁移文件 store_classes
php artisan make:model OrderSeller -m


# 前端代码打包
npm run prod

npm run watch

npm audit fix

composer require intervention/image

composer require yansongda/pay


如果图片商城的时候报权限错误
chmod -R 775 storage
php artisan storage:link

php artisan make:request Admin/AgreementsRequest

## Telescope 调试工具
https://learnku.com/docs/laravel/9.x/telescope/12275#available-watchers

php artisan make:command GenerateAdminCommand


