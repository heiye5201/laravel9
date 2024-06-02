## 项目一键部署
docker-compose up -d

## 执行数据库数据生成
php artisan database:create

## 初始数据生成
初始化 admin_menus 和 user_menus 表数据， 以及admins 用户表数据

php artisan database:initialize_menus
php artisan database:generate_admin
php artisan db:seed

## 生成oauth_clients 数据
php artisan passport:client

## 由于docker-compose.yml 设置自定义网络ip
检查网络情况
docker network ls
删除网络
docker network rm <network_name>

检查默认Docker网络的IP范围
docker network inspect bridge
