FROM registry.cn-hangzhou.aliyuncs.com/hzbs/node:20-alpine AS node-base

COPY xyz.meedu.admin /app/admin
COPY xyz.meedu.h5 /app/h5
COPY xyz.meedu.pc /app/pc

WORKDIR /app/admin
RUN pnpm i --frozen-lockfile && VITE_APP_URL=/api/ pnpm build

WORKDIR /app/pc
RUN pnpm i --frozen-lockfile && VITE_APP_URL=/api/ pnpm build

WORKDIR /app/h5
RUN pnpm i --frozen-lockfile && VITE_APP_URL=/api/ pnpm build

FROM registry.cn-hangzhou.aliyuncs.com/hzbs/php:7.4-fpm-alpine AS base

# Nginx配置文件
COPY docker/nginx/default.conf /etc/nginx/http.d/default.conf
# PHP配置文件
COPY docker/php/php.ini /usr/local/etc/php/php.ini
COPY docker/php/php-fpm.conf /usr/local/etc/php-fpm.conf
COPY docker/php/php-fpm.d /usr/local/etc/php-fpm.d
# API程序代码
COPY --chown=www-data:www-data xyz.meedu.api /var/www/api

COPY --from=node-base --chown=www-data:www-data /app/admin/dist /var/www/admin
COPY --from=node-base --chown=www-data:www-data /app/pc/dist /var/www/pc
COPY --from=node-base --chown=www-data:www-data /app/h5/dist /var/www/h5

# 设置工作目录
WORKDIR /var/www/api

# 安装依赖
RUN composer install --optimize-autoloader --no-dev

# laravel框架的一些操作
RUN php artisan route:cache && php artisan storage:link && php artisan install:lock

EXPOSE 8000
EXPOSE 8100
EXPOSE 8200
EXPOSE 8300

ENTRYPOINT ["tini", "--"]

CMD echo "Waiting for mysql/redis to start..."; sleep 15; php artisan meedu:upgrade; php artisan install administratorOnce; nginx; php-fpm