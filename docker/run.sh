#!/bin/bash

php artisan migrate --force
php artisan install config
php artisan install role
php artisan install administrator -q

nginx && php-fpm