#!/bin/bash

ssh -t matsu '
    cd /var/www/html

    git reset --hard && git clean -df
    git pull origin master
    composer install --no-interaction --prefer-dist --optimize-autoloader

    sudo -S service php7.4-fpm reload 

    if [ -f artisan ]; then
        php7.4 artisan migrate --force
    fi

    php7.4 artisan config:cache

    sudo npm ci

    sudo npm run production 
'

echo 'Deployed.'
