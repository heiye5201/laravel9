# Default Dockerfile

FROM php:8.1-fpm-alpine

LABEL maintainer="Shop Developers <heiye5201@aliyun.com>" version="1.0" license="MIT" app.name="jwj"

##
# ---------- env settings ----------
##
ARG timezone

ENV TIMEZONE=${timezone:-"Asia/Shanghai"} \
    APP_ENV=prod \
    SCAN_CACHEABLE=(true)

# update
RUN apk update \
    && apk add --no-cache autoconf build-base git unzip libzip-dev \
    && docker-php-ext-install zip pdo pdo_mysql mysqli \
    && pecl install redis \
    && docker-php-ext-enable redis

# 安装 Node.js，npm 及 yarn(如果需要)
RUN apk update && apk add --no-cache nodejs npm

# 安装 php-mysql 扩展
RUN #docker-php-ext-install mysqli pdo pdo_mysql
RUN #pecl install redis && docker-php-ext-enable redis

# 安装 Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Composer Cache
RUN composer install --no-dev --no-scripts

# COPY . /opt/www
WORKDIR /var/www


