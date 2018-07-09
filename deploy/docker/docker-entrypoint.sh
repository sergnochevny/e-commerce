#!/bin/sh
set -ex

cp -rf /app/deploy/config /app

if [ -f /app/deploy/db.sql ]; then
   mysql -uroot -proot -hiluvfabrix_db iluvfabrix < /app/deploy/db.sql
fi

cd /app

npm i
npm i npm
npm run build
composer -g config http-basic.tp.com tp tp \
    && composer -g config repositories composer https://tp.com/repo/private/ \
    && composer -g config repositories_packagist composer https://tp.com/repo/packagist/ \
    && composer -g config repositories.packagist false \
    && composer -g config -l \
    && composer global require "fxp/composer-asset-plugin:^1.2.0" --no-interaction \
    && composer install --no-interaction

rm -rf /app/deploy
rm -rf /app/deploy.dev
rm -rf /app/resources
rm -rf /app/node_modules

cd /

/bin/chown -R www-data:www-data /app
/bin/chmod -R 775 /app/web/images

exec "$@"