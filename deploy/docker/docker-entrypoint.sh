#!/bin/sh
set -ex

cp -rf /app/deploy/config/* /app

if [ -f /app/deploy/db.sql ]; then
   mysql -uroot -proot -hiluvfabrix_db iluvfabrix < /app/deploy/db.sql
fi

rm -rf /app/deploy
rm -rf /app/deploy.dev

/bin/chown -R www-data:www-data /app
/bin/chmod -R 775 /app/web/images

exec "$@"