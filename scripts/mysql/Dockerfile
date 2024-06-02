# 拉取仓库的mysql
FROM mysql:8.0

LABEL maintainer="jwj <heiye5201@aliyun.com>"

LABEL description="官方纯净版基础镜像"

# 将本地配置文件替换到镜像里
ADD my.cnf /etc/mysql/my.cnf

#设置环境变量 密码
ENV MYSQL_ROOT_PASSWORD=root

# 暴露 MySQL 默认端口
EXPOSE 3306

# 容器启动时执行的命令
CMD ["mysqld"]