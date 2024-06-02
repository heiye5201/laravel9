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


