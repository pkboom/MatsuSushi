#!/bin/bash

# run: ssh matsu 'cd /var/www/html && ./deploy.sh'

git reset --hard && git clean -df
git pull origin master
composer install --no-interaction --prefer-dist --optimize-autoloader

sudo -S service php7.4-fpm reload 

if [ -f artisan ]; then
    php artisan migrate --force
fi

php artisan config:cache

sudo npm ci

sudo npm run production