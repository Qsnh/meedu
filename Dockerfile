FROM node:20-alpine as nodeBase

RUN yarn global add pnpm &&\
  pnpm config set registry https://registry.npmmirror.com

# 编译后端
WORKDIR /app

COPY xyz.meedu.admin /app/admin
COPY xyz.meedu.h5 /app/h5
COPY xyz.meedu.pc /app/pc

# 编译后台
WORKDIR /app/admin
RUN pnpm i --frozen-lockfile && VITE_APP_URL=/api/ yarn build

# 编译PC
WORKDIR /app/pc
RUN pnpm i --frozen-lockfile && VITE_APP_URL=/api/ yarn build

# 编译H5
WORKDIR /app/h5
RUN pnpm i --frozen-lockfile && VITE_APP_URL=/api/ yarn build

FROM php:7.4-fpm-alpine as base

RUN sed -i 's/dl-cdn.alpinelinux.org/mirrors.tuna.tsinghua.edu.cn/g' /etc/apk/repositories

RUN apk update && apk upgrade && apk add --no-cache \
  bash \
  nginx \
  libzip-dev \
  freetype \
  libjpeg-turbo \
  libpng \
  freetype-dev \
  libjpeg-turbo-dev \
  libpng-dev \
  && docker-php-ext-configure gd \
  --with-freetype=/usr/include/ \
  --with-jpeg=/usr/include/ \
  && docker-php-ext-install -j$(nproc) gd \
  && docker-php-ext-enable gd \
  && apk del --no-cache \
  freetype-dev \
  libjpeg-turbo-dev \
  libpng-dev \
  && rm -rf /tmp/*

RUN docker-php-ext-install pdo pdo_mysql zip bcmath pcntl opcache

COPY --from=nodeBase --chown=www-data:www-data /app/admin/dist /var/www/admin
COPY --from=nodeBase --chown=www-data:www-data /app/pc/dist /var/www/pc
COPY --from=nodeBase --chown=www-data:www-data /app/h5/dist /var/www/h5

# Nginx配置文件
COPY docker/nginx/default.conf /etc/nginx/http.d/default.conf

# PHP配置文件
COPY docker/php/php.ini /usr/local/etc/php/php.ini
COPY docker/php/php-fpm.conf /usr/local/etc/php-fpm.conf
COPY docker/php/php-fpm.d /usr/local/etc/php-fpm.d

# PHP-FPM运行日志目录
RUN mkdir -p /var/log/php
RUN chown -R www-data:www-data /var/log/php

# 安装composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# 下载API程序代码
COPY --chown=www-data:www-data xyz.meedu.api /var/www/api

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

COPY docker/run.sh /run.sh
RUN chmod +x /run.sh

CMD ["sh", "/run.sh"]
