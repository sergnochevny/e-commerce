#!/bin/sh
set -ex

cp -rf /app/deploy/config /app

if [ -f /app/deploy/db.sql ]; then
   mysql -uroot -proot -hiluvfabrix_db iluvfabrix < /app/deploy/db.sql
fi

rm -rf /app/deploy
rm -rf /app/deploy.dev

cd /app
composer -g config http-basic.tp.ait.com tp tp \
    && composer -g config repositories.ait composer https://tp.ait.com/repo/private/ \
    && composer -g config repositories.ait_packagist composer https://tp.ait.com/repo/packagist/ \
    && composer -g config repositories.packagist false \
    && composer -g config -l \
    && composer global require "fxp/composer-asset-plugin:^1.2.0" --no-interaction \
    && composer install --no-interaction

/bin/chown -R www-data:www-data /app
/bin/chmod -R 775 /app/web/images

exec "$@"