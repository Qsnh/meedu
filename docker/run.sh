#!/bin/sh

echo "Waiting for mysql/redis to start..."

sleep 15

php /var/www/api/artisan migrate --force
php /var/www/api/artisan install config
php /var/www/api/artisan install role
php /var/www/api/artisan install administrator -q

nginx && php-fpm