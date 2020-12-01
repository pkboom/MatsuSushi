cd /var/www/html
git pull origin master
composer install --no-interaction --prefer-dist --optimize-autoloader

( flock -w 10 9 || exit 1
    echo 'Restarting FPM...'; sudo -S service php-fpm7.4 reload ) 9>/tmp/fpmlock

if [ -f artisan ]; then
    php artisan migrate --force
fi

npm ci

npm run production