# 拉取仓库的redis
FROM redis:6.0

LABEL maintainer="jwj <jwj@126.me>"

LABEL description="官方纯净版基础镜像"

# 将本地redis配置文件替换到镜像里
ADD redis.conf /usr/local/etc/redis/redis.conf

# 暴漏端口
EXPOSE 6379

# 启动命令
CMD [ "redis-server", "/usr/local/etc/redis/redis.conf" ]