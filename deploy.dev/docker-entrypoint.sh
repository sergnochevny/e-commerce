#!/bin/sh
set -ex
cd /app
composer -g config http-basic.tp.com tp tp \
    && composer -g config repositories.ait composer https://tp.com/repo/private/ \
    && composer -g config repositories_packagist composer https://tp.com/repo/packagist/ \
    && composer -g config repositories.packagist false \
    && composer -g config -l \
    && composer global require "fxp/composer-asset-plugin:^1.2.0" --no-interaction \
    && composer install --no-interaction

/bin/chown -R www-data:www-data /app
exec "$@"