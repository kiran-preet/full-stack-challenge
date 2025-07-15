#!/bin/bash
# Run migrations only if this is the first run
if [ ! -f "/var/www/html/.migrated" ]; then
    php artisan migrate --force
    php artisan db:seed --force
    touch /var/www/html/.migrated
fi

# Start server
php artisan serve --host=0.0.0.0 --port=8000