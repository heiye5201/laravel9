FROM php:8.1-fpm-alpine

LABEL maintainer="jwj <jwj@126.me>"
LABEL description="官方纯净版基础镜像，php镜像"

# 安装常用的 PHP 扩展和工具
RUN apk update \
    && apk add --no-cache git unzip libzip-dev autoconf build-base \
    && docker-php-ext-install zip pdo pdo_mysql mysqli \
    && pecl install redis \
    && docker-php-ext-enable redis


# 设置工作目录
WORKDIR /var/www

# 如果有其他需要的配置或命令，可以在这里添加

# 暴露 PHP-FPM 端口（如果需要）
# EXPOSE 9000

# 启动 PHP-FPM（如果需要）
CMD ["php-fpm"]
#CMD ["/bin/bash"]

# 如果有其他启动命令，可以在这里添加
