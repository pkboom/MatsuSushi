cd /var/www/html
git pull origin master
composer install --no-interaction --prefer-dist --optimize-autoloader

sudo -S service php-fpm7.4 reload 

if [ -f artisan ]; then
    php artisan migrate --force
fi

sudo npm ci

sudo npm run production