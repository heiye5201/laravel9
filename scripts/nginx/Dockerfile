FROM nginx:1.16

LABEL maintainer="jwj <heiye5201@aliyun.com>"
LABEL description="官方纯净版基础镜像，nginx镜像"

# 创建名为"nginx"的用户，UID为1001
RUN adduser -D -H -u 1001 -s /bin/sh nginx

# 删除默认配置文件
RUN rm /etc/nginx/conf.d/default.conf

# 添加自定义nginx配置文件和站点配置文件
ADD nginx.conf /etc/nginx/
ADD sites-available/backend.conf /etc/nginx/sites-available/

# 将/var/www目录设置为可挂载的卷
VOLUME /var/www

# 启动nginx
CMD ["nginx", "-g", "daemon off;"]
